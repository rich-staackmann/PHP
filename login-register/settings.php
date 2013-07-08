<?php 
  include 'core\init.php'; 
  protect_page();
  include 'includes\head.php';
  //logic here is SIMILAR to the changepassword.php page
  if(!empty($_POST)) {
    $required_fields = array('first_name', 'email');
    foreach($_POST as $key => $value) {
      if(empty($value) && in_array($key, $required_fields)) {
        $errors[] = 'You are missing the required value '.$key;
        break 1;
      }
    }
    if(empty($errors)) {
      if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'A valid email is required';
      }
      if(email_exists($_POST['email']) && $user_data['email'] !== $_POST['email']) {
        $errors[] = 'That email has laready been registered';
      }
    }
  }
?>
  
  <?php 
    if(isset($_GET['success'])) {
      echo "You have successfully changed your account settings.";
    }
    else {
      if(!empty($_POST) && empty($errors)) {
        $update_data = array('first_name' => $_POST['first_name'], 'last_name' => $_POST['last_name'], 'email' => $_POST['email']);
        update_user($update_data);
        header('Location: settings.php?success');
        exit();
      } else if(!empty($errors)) {
        echo output_errors($errors);
      }
  ?>
  
  <h1>Edit account settings</h1>
  
  <form action="" method="post">
    <ul>
      <li>
        First Name: <br>
        <input type="text" name="first_name" value="<?php echo $user_data['first_name'] ?>">
      </li>
      <li>
        Last Name: <br>
        <input type="text" name="last_name" value="<?php echo $user_data['last_name'] ?>">
      </li>
      <li>
        Email: <br>
        <input type="text" name="email" value="<?php echo $user_data['email'] ?>">
      </li>
      <li>
        <input type="submit" value="Change settings">
      </li>
    </ul>
  </form>
  
<?php 
  } //wont show form after the settings change has been submitted, corresponds to line 29
  include 'includes\overall\footer.php'; 
 ?>