<?php
  if(empty($_POST) === false) {
    echo '<p>'.'Submitted'.'</p>';
    $errors = array();
    $name = $_POST['name']; //remember, post returns the NAME attribute from input elements
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    if(empty($name) === true || empty($email) === true || empty($message) === true){
      $errors[] = 'Name, email, and message are required';
    } else {
      if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
        $errors[] = 'That is not a valid email';
      }
      if(ctype_alpha($name) === false){
        $errors[] = 'Name must only have letters';
      }
    }
    if(empty($errors) === true){
      //send email here, need to setup smtp
      //mail('example@example.com', 'Contact message', $message, 'From: ' . $email);
      header('Location: contact.php?sent');
      exit();
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
      <title>Contact Form</title>
  </head>
  <body>
    <?php 
      if(isset($_GET['sent']) === true){
        echo '<p>Thanks for contacting us.</p>';
      } 
      else {
        if(empty($errors) === false){
          echo '<ul>';
          foreach($errors as $error) {
            echo '<li>',$error,'</li>';
          }
          echo '</ul>';
        }
      ?>
      <form action="" method="POST">
        <p>
          <label for="name">Name:</label><br>
          <input type="text" name="name" id="name" <?php if(isset($_POST['name']) === true) { echo 'value="',strip_tags($_POST['name']),'"'; } ?>>
        </p>
        <p>
          <label for="email">Email:</label><br>
          <input type="text" name="email" id="email" <?php if(isset($_POST['email']) === true) { echo 'value="',strip_tags($_POST['email']),'"'; } ?>>
        </p>
        <p>
          <label for="message">Message:</label><br>
          <textarea name="message" id="message"><?php if(isset($_POST['message']) === true) { echo strip_tags($_POST['message']); } ?></textarea>
        </p>
        <p>
          <input type="submit" name="Submit">
        </p>
      </form>
    <?php 
      }
    ?>
  </body>
</html>