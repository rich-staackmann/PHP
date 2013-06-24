<?php 

session_start();
require_once 'connect.php';
require_once 'protect.php';

$_SESSION['uid'] = 1; //dummy user id 
$_SESSION['name'] = 'clayton'; //dummy name

if(isset($_POST['submit'])) 
{
  $shout = protect($_POST['shout']);
  $shout = (string)$shout;
  global $db; 
  
  if(strlen($shout) > 255)
  {
    echo 'Your shout must be 255 characters long or shorter.';
  } 
  else if($shout !== '')
  {
    if(isset($_POST['name'])) 
    {
      $name = protect($_POST['name']);
      $query = $db->query("SELECT username FROM users WHERE username = $name");
      if($query->fetchColumn(0) > 0) 
        echo 'That name is already in use';
      else if($name !=='')
      {
        if(strlen($name) > 32)
          echo 'Your name can\'t be greater than 32 characters';
        else
          $db->query("INSERT INTO `shouts` SET `user_id` = 0, `date_posted` = NOW(), `message` = '$shout', `name` = '$name'");
      }
    }
    else 
      $db->query("INSERT INTO shouts (user_id, date_posted, message) 
                  VALUES (".$_SESSION['uid'].", NOW(), '$shout')");
  }
}


?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Shoutbox</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#shoutbox').load('shouts.php');
        setInterval(function () {$('#shoutbox').load('shouts.php');}, 10000);
      });
      
    </script>
  </head>
  <body>
    <div id="shoutbox">
      
    </div>
    <hr>
    <p>Give a shout!</p>
    <form method="post" action="">
      <?php if(!isset($_SESSION['uid'])) : ?>
      <div>
        <label for="name">Name: </label>
        <input type="text" name="name">
      </div>
      <?php endif; ?>
      <div>
        <label for="shout">Shout: </label>
        <input type="text" name="shout">
      </div>
      <input type="submit" name="submit" value="Shout">
    </form>
    
  </body>
</html>