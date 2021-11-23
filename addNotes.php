<?php 
require_once 'classes/Page.php';
require_once 'classes/crud.php';
$page = new Page();
$crud = new Crud();

$output = "";

if(isset($_POST['addNote'])){
  $output = $crud->addNotes();
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>PDO Crud Example</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">

    
  </head>
  <body>
    <div class="container">
      <header>
        <h1>Add Note</h1>
        <?php echo $page->nav(); ?>
        <form method="post" action="addNotes.php" >
        <input type="datetime-local" class="form-control" id="note_date" name="note_date">
        
      </header>
        <main>
        
      
        <textarea class="form-control" id="note_content" name="note_content" rows="10"></textarea>
        <input type="submit" name="addNote" id="addNote"></input>
</form>
      </main>

    </div>
  </body>
</html>