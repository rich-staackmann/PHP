<?php 
  //checks if the session has a set userID, this means they are logged in
  function logged_in() {
    return (isset($_SESSION['user_id'])) ? true : false;
  }
  //check if this username is already in the database. users must be unique
  function user_exists($username){
    global $db;
    $username = sanitize($username);
    $query = $db->query("SELECT COUNT(user_id) FROM users WHERE username = '$username'");
    return ($query->fetchColumn(0) == 1) ? true : false;
  }
  //checks if the email is already in our DB
  function email_exists($email){
    global $db;
    $email = sanitize($email);
    $query = $db->query("SELECT COUNT(user_id) FROM users WHERE email = '$email'");
    return ($query->fetchColumn(0) == 1) ? true : false;
  }
  //checks if the user has activated their account 
  function user_active($username){
    global $db;
    $username = sanitize($username);
    $query = $db->query("SELECT COUNT(user_id) FROM users WHERE username = '$username' AND active = 1");
    return ($query->fetchColumn(0) == 1) ? true : false;
  }
  //returns a userId from a username
  function user_id_from_username($username) {
    $username = sanitize($username);
    global $db;
    $query = $db->query("SELECT user_id FROM users WHERE username = '$username'");
    return $query->fetchColumn();
  }
  //logs the user in and returns their userID or false if that user cant be logged in
  function login($username, $password){
    global $db;
    $user_id = user_id_from_username($username);
    $username = sanitize($username);
    $password = md5($password);
    
    $query = $db->query("SELECT COUNT(user_id) FROM users WHERE username = '$username' AND password = '$password'");
    return ($query->fetchColumn(0) == 1) ? $user_id : false;
  }
  //this returns a variable parameter list of the user's data. email, name, etc
  function user_data($user_id){
    $data = array();
    $user_id = (int)$user_id;
    global $db;
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    
    if($func_num_args > 1) {
      unset($func_get_args[0]); //unset the first parameter, because it isnt for the list of data we want
      $fields = '`'.implode('`, `', $func_get_args).'`'; //format this for direct input to a sql query
      $query = $db->query("SELECT $fields FROM users WHERE user_id = $user_id");
      $data = $query->fetch(PDO::FETCH_ASSOC);
      return $data;
    }
  }
  //this counts the number of registered users for a widget
  function user_count() {
    global $db;
    $query = $db->query("SELECT COUNT(user_id) FROM users WHERE active = 1");
    return $query->fetchColumn();
  }
  //this will add the user to our DB
  function register_user($register_data) {
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);
    global $db;
    
    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $data = '\'' . implode('\', \'',$register_data) . '\'';
    //the implodes will make the two arrays LOOK just like sql syntax, so we can input them into a query
    $db->query("INSERT INTO `users`($fields) VALUES ($data)");
    email($register_data['email'], 'Activate your account', "Hello ".$register_data['first_name'].",\n\nYou need to activate your account, so use the following link.\n\n http://localhost/udemy_php_tut/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code']."\n\nFrom admin");
  }
  //this will change the user's password
  function change_password($user_id, $password) {
    $user_id = (int)$user_id;
    $password = md5($password);
    global $db;
    
    $db->query("UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id");
  }
  //this will activate a user in the DB 
  function activate($email, $email_code) {
    $email = sanitize($email);
    $email_code = sanitize($email_code);
    global $db;
    $query = $db->query("SELECT COUNT(user_id) FROM `users` WHERE email = '$email' AND email_code='$email_code' AND active = 0");
    if($query->fetchColumn(0) == 1) {
      $db->query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
      return true;
    }else {
      return false;
    }
  }
  //this function will update user data in the DB 
  function update_user($update_data) {
    array_walk($update_data, 'array_sanitize'); //run sanitize on each array value
    global $db;
    global $session_user_id;
    $update = array();
    
    foreach($update_data as $field => $data) {
      $update[] = $field.' = \''.$data.'\''; //add each key=>value to an array 
    } //the update array looks like.... first_name = 'x' ..we can just input it into a query now
    $db->query("UPDATE `users` SET ".implode(', ',$update)." WHERE user_id = $session_user_id");
  }
  //will get the userID from the user's email
  function user_id_from_email($email) {
    $email = sanitize($email);
    global $db;
    $query = $db->query("SELECT user_id FROM users WHERE email = '$email'");
    return $query->fetchColumn();
  }
  //this func will recover either a username or a password, based on the MODE argument
  function recover($mode, $email) {
    $email = sanitize($email);
    $mode = sanitize($mode);
    global $db;
    $user_data = user_data(user_id_from_email($email), 'user_id', 'first_name', 'username');
    
    if($mode === 'username') { //we just email the user their username
      email($email, 'Your username', "Hello, your username is ".$user_data['username']);
    } else if($mode === 'password') {
      $generated_password = substr(md5(rand(999, 999999)), 0, 8); //generates a random hash and truncates it to 8 characters
      change_password($user_data['user_id'], $generated_password);
      email($email, 'Your password recovery', 'We have temporarily generated a password for you, please use it to change your password.\n'.$generated_password);
    }
  }
  //checks if user is an admin or moderator...basically it checks for any elevated privilege
  function has_access($user_id, $type) { //the type is the type of privilege....1 for admin, 2 for moderator
    $user_id = (int)$user_id;
    $type = (int)$type;
    global $db;
    $query = $db->query("SELECT COUNT(user_id) FROM users WHERE user_id = '$user_id' AND type = $type");
    return ($query->fetchColumn(0) == 1) ? true : false;
  }
  //this function is used to change a user's privileges
  function change_privilege($username, $type) { //the type is the type of privilege....1 for admin, 2 for moderator
    $user_id = user_id_from_username($username);
    $type = (int)$type;
    global $db;
    $query = $db->query("UPDATE users SET type = $type WHERE user_id = $user_id");
  }
?>