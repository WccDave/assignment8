<?php
require_once 'classes/Page.php';
require_once 'classes/crud.php';
$page = new Page();
$crud = new Crud();

$output = "";

if(isset($_POST['getNote'])){
  $output = $crud->getNotesByDate('list');
  
} else {
  $output = $crud->getNotes('list');
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
        <h1>Show Notes</h1> 
      </header>
      <?php echo $page->nav(); ?>
    </div>  
    <div>
    <div id="noteList"></div>
    </div>
    <main>
    <form method="post" action="showNotes.php">  
        <div class="container d-grid gap-3">
            <div class="m-5 bg-light border">
                <input type="date" class="form-control" id="begDate" name="begDate">
            </div>
            <div class="m-5 bg-light border">
                <input type="date" class="form-control" id="endDate" name="endDate">
            </div >    
            <input type="submit" name="getNote" id="getNote"></input>
        </div>   
    </form>
    <div class="container">
    <table class="table">
    <thead>
    <tr>
      
      <th scope="col">Note Date</th>
      <th scope="col">Note Content</th>
      
    </tr>
  </thead>
  
  <?php echo $output; ?>
  
</table>
</div>
    </main>

    </div>
  </body>
</html>