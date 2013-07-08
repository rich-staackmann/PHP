<?php 
  include 'core\init.php'; 
  logged_in_redirect();
  include 'includes\head.php';
  
  if(!empty($_POST)) {
    $required_fields = array('username', 'password', 'password_again', 'first_name', 'email');
    //required fields can be easily changed whenever 
    foreach($_POST as $key => $value) {
      if(empty($value) && in_array($key, $required_fields)) {
        $errors[] = 'You are missing the required value '.$key;
        break 1;
      }
    }
    //validations for the form fields
    if(empty($errors)) {
      if(user_exists($_POST['username'])) {
        $errors[] = 'This username is already taken';
      }
      if(preg_match("/\\s/", $_POST['username']) == true) {
        $errors[] = 'Your username must not contain any spaces';
      }
      if(strlen($_POST['password']) < 6) {
        $errors[] = 'Your password must be atleast 6 characters';
      }
      if($_POST['password'] !== $_POST['password_again']) {
        $errors[] = 'Your passwords do not match';
      }
      if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'A valid email is required';
      }
      if(email_exists($_POST['email'])) {
        $errors[] = 'That email has laready been registered';
      }
    } 
  } 
?>

  <h1>Register</h1>
  
  <?php 
    if(isset($_GET['success'])) {
      echo "You have successfully registered. An email will be sent to you to finish account activation";
    }
    else {
      if(!empty($_POST) && empty($errors)) {
        $register_data = array(
          'username'    => $_POST['username'],
          'password'    => $_POST['password'],
          'first_name'  => $_POST['first_name'],
          'last_name'   => $_POST['last_name'],
          'email'       => $_POST['email'],
          'email_code'  => md5($_POST['username'] + microtime())
        ); //email code will be a unique code for activating the user
        register_user($register_data);
        header('Location: register.php?success');
        exit();
      } else if(!empty($errors)) {
        echo output_errors($errors);
      }
  ?>
  
  <form action="" method="post">
    <ul>
      <li>
        Username*:<br>
        <input type="text" name="username">
      </li>
      <li>
        Password*:<br>
        <input type="password" name="password">
      </li>
      <li>
        Password again*:<br>
        <input type="password" name="password_again">
      </li>
      <li>
        First name*:<br>
        <input type="text" name="first_name">
      </li>
      <li>
        Last name:<br>
        <input type="text" name="last_name">
      </li>
      <li>
       Email*:<br>
       <input type="text" name="email">
      </li>
      <li>
        <input type="submit" value="Register">
      </li>
    </ul>
  </form>

<?php 
  } //wont show form if the user has successfully registered, corresponds to else at line 47
  include 'includes\overall\footer.php'; 
?>   