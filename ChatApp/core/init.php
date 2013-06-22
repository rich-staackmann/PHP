<?php 
  session_start();
  //here we fake the user_id for our session, normally the user would have this already
  define('LOGGED_IN', true);
  
  require 'classes\Core.php';
  require 'classes\Chat.php';
?>