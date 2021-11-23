<?php

class Page {
	public function nav(){
		$nav = <<<NAV
      <nav>
        <ul>
          <li><a href="showNotes.php">Note List</a></li>
          <li><a href="addNotes.php">Add Note</a></li>
          
        </ul>
      </nav>
NAV;
		return $nav;
	}
}
/*<li><a href="update_delete_files.php">Update/Delete Files</a></li>*/