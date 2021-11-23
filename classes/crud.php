<?php
require 'classes/Pdo_methods.php';

class Crud extends PdoMethods{

	public function getNotes($type){
		
		/* CREATE AN INSTANCE OF THE PDOMETHODS CLASS*/
		$pdo = new PdoMethods();

		/* CREATE THE SQL */
		$sql = "SELECT * FROM notes";
		//$sql = "SELECT * FROM notes WHERE note_date BETWEEN $_POST['begDate'] AND $_POST['endDate']";
		//PROCESS THE SQL AND GET THE RESULTS
		$records = $pdo->selectNotBinded($sql);

		/* IF THERE WAS AN ERROR DISPLAY MESSAGE */
		if($records == 'error'){
			return 'There has been and error processing your request';
		}
		else {
			if(count($records) != 0){
				if($type == 'list'){return $this->createList($records);}
				if($type == 'input'){return $this->createInput($records);}	
			}
			else {
				return 'no notes found';
			}
		}
	}

	public function getNotesByDate($type){
		
		/* CREATE AN INSTANCE OF THE PDOMETHODS CLASS*/
		$pdo = new PdoMethods();
		$begDate = $_POST['begDate'];
		$endDate = $_POST['endDate'];
		/* CREATE THE SQL */
		//$sql = "SELECT * FROM notes";
		$sql = "SELECT * FROM notes WHERE note_date BETWEEN '$begDate' AND '$endDate'";
		//PROCESS THE SQL AND GET THE RESULTS
		$records = $pdo->selectNotBinded($sql);

		/* IF THERE WAS AN ERROR DISPLAY MESSAGE */
		if($records == 'error'){
			return 'There has been and error processing your request';
		}
		else {
			if(count($records) != 0){
				if($type == 'list'){return $this->createList($records);}
				if($type == 'input'){return $this->createInput($records);}	
			}
			else {
				return 'no notes found';
			}
		}
	}


	public function addNotes(){
	
		$pdo = new PdoMethods();

		/* HERE I CREATE THE SQL STATEMENT I AM BINDING THE PARAMETERS */
		$sql = "INSERT INTO notes (note_content, note_date) VALUES (:note_content, :note_date)";

			 
	    /* THESE BINDINGS ARE LATER INJECTED INTO THE SQL STATEMENT THIS PREVENTS AGAIN SQL INJECTIONS */
	    $bindings = [
			[':note_content',$_POST['note_content'],'str'],
			[':note_date',$_POST['note_date'],'str']
		];

		/* I AM CALLING THE OTHERBINDED METHOD FROM MY PDO CLASS */
		$result = $pdo->otherBinded($sql, $bindings);

		/* HERE I AM RETURNING EITHER AN ERROR STRING OR A SUCCESS STRING */
		if($result === 'error'){
			return 'There was an error adding the note';
		}
		else {
			return 'note has been added';
		}
	}

	public function updateNotes($post){
		$error = false;

		if(isset($post['inputDeleteChk'])){

			foreach($post['inputDeleteChk'] as $id){
				$pdo = new PdoMethods();

				/* HERE I CREATE THE SQL STATEMENT I AM BINDING THE PARAMETERS */
				$sql = "UPDATE notes SET note_content = :note_content, note_date = :note_date WHERE note_id = :note_id";

				//THE ^^ WAS USED TO MAKE EACH ITEM UNIQUE BY COMBINING FNAME WITH THEY ID
				$bindings = [
					[':note_content', $post["note_content^^{$id}"], 'str'],
					[':note_date', $post["note_[date^^{$id}"], 'str']
				];

				$result = $pdo->otherBinded($sql, $bindings);

				if($result === 'error'){
					$error = true;
					break;
				}
				
			}

			if($error){
				return "There was an error in updating a note or notes";
			}
			else {
				return "All notes updated";
			}
		}
		else {
			return "No notes selected to update";
		}
	}

	public function deleteNotes($post){
		$error = false;
		if(isset($post['inputDeleteChk'])){
			foreach($post['inputDeleteChk'] as $id){
				$pdo = new PdoMethods();

				$sql = "DELETE FROM notes WHERE note_id=:note_id";
				
				$bindings = [
					[':note_id', $id, 'int'],
				];


				$result = $pdo->otherBinded($sql, $bindings);

				if($result === 'error'){
					$error = true;
					break;
				}
			}
			if($error){
				return "There was an error in deleting a note or notes";
			}
			else {
				return "All notes deleted";
			}

		}
		else {
			return "No notes selected to delete";
		}
	}

	/*THIS FUNCTION TAKES THE DATA FROM THE DATABASE AND RETURN AN UNORDERED LIST OF THE DATA*/
	private function createList($records){
	
		$list = '<tbody>';
		foreach ($records as $row){
			$list .= "<tr><td>{$row['note_date']}</td><td>{$row['note_content']}</td></tr>";
		}
		$list .= '</tbody>';
		return $list;
	}

	/*THIS FUNCTION TAKES THE DATA AND RETURNS THE DATA IN INPUT ELEMENTS SO IT CAN BE EDITED.  */
	private function createInput($records){
		$output = "<form method='post' action='update_delete_notes.php'>";
		$output .= "<input class='btn btn-success' type='submit' name='update' value='Update'>";
		$output .= "<input class='btn btn-danger' type='submit' name='delete' value='Delete'>";
		$output .= "<table class='table table-bordered table-striped'><thead><tr>";
		$output .= "<th>Note Date</th><th>Note Content</th><th>Update/Delete</th><tbody>";
		foreach ($records as $row){
			$output .= "<tr><td><input type='text' class='form-control' name='note_content^^{$row['note_id']}' value='{$row['note_content']}'></td>";

			$output .= "<td><input type='text' class='form-control' name='note_date^^{$row['note_id']}' value='{$row['note_date']}'></td>";

			$output .= "<td><input type='checkbox' name='inputDeleteChk[]' value='{$row['note_id']}'></td></tr>";
		}
		
		$output .= "</tbody></table></form>";
		return $output;
	}
}