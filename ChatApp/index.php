<?php 
  session_start();
  $_SESSION['user'] = (isset($_GET['user']) === true) ? (int)$_GET['user'] : 0;
  
  require 'core\classes\Core.php';
  require 'core\classes\Chat.php';
  
  $chat = new Chat();
  
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Chat App</title>
    <link rel="stylesheet" href="css\styles.css">
  </head>
  <body>
    
    <div class="chat">
      <div class="messages">
        <!-- holder div for messages that php will place -->
      </div>
      <textarea class="entry" placeholder="Type here and hit return. Use shift + return to add a new line."></textarea>
    </div>
    
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="js\chat.js"></script>
  </body>
</html>