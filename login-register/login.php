<?php 
  include 'core\init.php';
  logged_in_redirect();
  include 'includes\head.php';
  
  if(!empty($_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(empty($username) || empty($password)) {
      $errors[] = 'You must enter both a username and password';
    } else if(!user_exists($username)){
      $errors[] = 'You need to be a registered user to login.';
    } else if(!user_active($username)) {
      $errors[] = 'You need to activate your account to login.';
    } else {
      $login = login($username, $password);
      
      if($login === false) {
        $errors[] = 'Password is incorrect.';
      } else {
        $_SESSION['user_id'] = $login;
        header('Location: index.php');
        exit();
      }
    }
  } else {
    $errors[] = 'No data received';
  }
  
  if(!empty($errors)) {
    echo '<h2>We tried to log you in but...</h2>';
    echo output_errors($errors);
  }
  
  include 'includes\overall\footer.php';
?>