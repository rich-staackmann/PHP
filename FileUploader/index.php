<?php 
  if(isset($_FILES['upload'])){
    $files = $_FILES['upload'];
    
    for($x = 0; $x < count($files['name']); $x++){
      $name     = $files['name'][$x];
      $tmp_name = $files['tmp_name'][$x];
      
      move_uploaded_file($tmp_name, 'uploads\\'.$name);
    }
  }
?>

<form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="upload[]"> <!-- adding the multiple attribute here allows for many files to be selected in the file dialog -->
  <input type="file" name="upload[]">
  <input type="submit" value="Upload">
</form>