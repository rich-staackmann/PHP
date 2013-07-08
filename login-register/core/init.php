<?php 
  //initializes our DB connection and adds the various libs we create
  session_start();
  
  require 'db\connect.php';
  require 'func\general.php';
  require 'func\users.php';
 
  if(logged_in()){
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id,'user_id', 'username', 'password', 'first_name', 'last_name', 'email', 'type');
    if(!user_active($user_data['username'])){
      session_destroy();
      header('Location: index.php');
      exit();
    }
  }
  $errors = array();
?>