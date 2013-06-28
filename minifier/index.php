<?php 
  if(isset($_FILES['upload']) && !empty($_FILES['upload'])){
    $files    = $_FILES['upload'];
    $name     = $files['name'];
    $tmp_name = $files['tmp_name'];
    
    move_uploaded_file($tmp_name, 'files\\'.$name);
    $filename = 'files\\'.$name;
    if(is_readable($filename)) {
      $contents = file_get_contents($filename);
      echo "Before: <br>", "<pre>", htmlentities($contents), "</pre>";
      $contents = preg_replace('/[\r\n]+/', ' ', preg_replace('/\t+/', ' ', $contents));
      // windows uses \r\n as its newline character, so [\r\n]+ will match the \r\n combination as many times as possible
      // this means it will catch mutliple new lines
      // \t is for tabs, so \t+ will match 1 or more tabs
      echo "After: <br>", "<pre>", htmlentities($contents), "</pre>";
      file_put_contents('files\\min-'.$name, $contents);
      //append min- to the filename. im not serving the file back or anything because this is more of a regex test
    }
  }
?>

<form action="" method="post" enctype="multipart/form-data">
  <input type="file" name="upload"><br> <!-- adding the multiple attribute here allows for many files to be selected in the file dialog -->
  <input type="submit" value="Minify">
</form>