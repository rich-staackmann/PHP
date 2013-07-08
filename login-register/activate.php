<?php 
  include 'core\init.php'; 
  logged_in_redirect();
  include 'includes\head.php'; 
  //the includes for head and footer are all of the sites html.
  //any page we want to create just needs two simple includes and it will fit in 
  //with the rest of the site 
  
  if(isset($_GET['email'], $_GET['email_code'])) {
    $email      = trim($_GET['email']);
    $email_code = trim($_GET['email_code']);
    if(!email_exists($email)) {
      $errors[] = 'This email does not exist.';
    } else if(!activate($email, $email_code)) {
       $errors[] = 'We had problems activating your account';
    }
  } 
  else {
    header('Location: index.php');
    exit();
  }
?>

  <h1>Activation</h1>
  <?php 
    if(!empty($errors)) {
      echo output_errors($errors);
    } else {
      echo 'Activation successful, please log in.';
    }
  ?>
  
<?php include 'includes\overall\footer.php'; ?>   