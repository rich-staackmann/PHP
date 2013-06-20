<?php 
  session_start();
  //here we fake the user_id for our session, normally the user would have this already
  $_SESSION['user_id'] = '1';
  
  include 'C:\wamp\www\udemy_php_tut\likeButton\core\db\connect.php';
  include 'C:\wamp\www\udemy_php_tut\likeButton\core\func\articles.php';
  include 'C:\wamp\www\udemy_php_tut\likeButton\core\func\like.php';
?>