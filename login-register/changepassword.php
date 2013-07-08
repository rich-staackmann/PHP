<?php 
  include 'core\init.php'; 
  protect_page();
  include 'includes\head.php';
  //logic here is SIMILAR to the register.php page
  if(!empty($_POST)) {
    $required_fields = array('current_password', 'password', 'password_again');
    foreach($_POST as $key => $value) {
      if(empty($value) && in_array($key, $required_fields)) {
        $errors[] = 'You are missing the required value '.$key;
        break 1;
      }
    }
    if(empty($errors)) {
      if($user_data['password'] !== md5($_POST['current_password'])) {
        $errors[] = 'Your current password is incorrect.';
      }
      if(strlen($_POST['password']) < 6) {
        $errors[] = 'Your password must be atleast 6 characters';
      }
      if(trim($_POST['password']) !== trim($_POST['password_again'])) {
        $errors[] = 'Your passwords do not match';
      }
    }
  }
?>
  
  <?php 
    if(isset($_GET['success'])) {
      echo "You have successfully changed your password.";
    }
    else {
      if(!empty($_POST) && empty($errors)) {
        change_password($session_user_id, $_POST['password']);
        header('Location: changepassword.php?success');
        exit();
      } else if(!empty($errors)) {
        echo output_errors($errors);
      }
  ?>
  
  <h1>Change Password</h1>
  
  <form action="" method="post">
    <ul>
      <li>
        Current password: <br>
        <input type="password" name="current_password">
      </li>
      <li>
        New password: <br>
        <input type="password" name="password">
      </li>
      <li>
        New password again: <br>
        <input type="password" name="password_again">
      </li>
      <li>
        <input type="submit" value="Change password">
      </li>
    </ul>
  </form>
  
<?php 
  } //wont show form after the password change has been submitted, corresponds to line 32
  include 'includes\overall\footer.php'; 
 ?>   