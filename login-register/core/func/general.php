<?php 
  //a function to sanitize data of sql 
  function sanitize($data) {
    return htmlentities(strip_tags(mysql_real_escape_string($data)));
  }
  //used to sanitize an array, notice it takes a reference to an item
  function array_sanitize(&$item){
    $item = htmlentities(strip_tags(mysql_real_escape_string($item)));
  }
  //this will output our errors array in a nice unordered list
  function output_errors($errors) {
    $output = array();
    foreach($errors as $error) {
      $output[] = '<li>'.$error.'</li>';
    }
    return '<ul>'.implode('', $output).'</ul>';
  }
  //this protects a page from users who haven't logged in
  function protect_page() {
    if(!logged_in()) {
      header('Location: protected.php');
      exit();
    }
  }
  //this protects a page from logged in users...like the login page or register page
  function logged_in_redirect() {
    if(logged_in()) {
      header('Location: index.php');
      exit();
    }
  }
  //send an email to a user
  //i dont have smtp setup locally
  function email($to, $subject, $body) {
    mail($to, $subject, $body, 'From: admin@example.com');
  }
  //this func protects administrative pages from access by non-admin users
  function admin_protect() {
    global $user_data;
    if($user_data['type'] != 1) {
      header("location: index.php");
      exit();
    }
  }
?>