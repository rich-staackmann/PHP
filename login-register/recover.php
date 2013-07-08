<?php 
  include 'core\init.php'; 
  logged_in_redirect();
  include 'includes\head.php'; 
?>

  <h1>Recover</h1>
  <?php 
    if(isset($_GET['success'])) {
      echo '<p>Your recovery is successful. An email has been sent.</p>';
    } else {
      $mode_allowed = array('username','password');
      if(isset($_GET['mode']) && in_array($_GET['mode'], $mode_allowed)) {
        if(isset($_POST['email']) && !empty($_POST['email'])) {
          if(email_exists($_POST['email'])) {
            recover($_GET['mode'], $_POST['email']);
            header("Location: recover.php?success");
          } else {
            echo "<p>We could not find that email.</p>";
          }
        }
      ?>
      <form action="" method="post">
        <ul>
          <li>
            Please type your email:<br>
            <input type="text" name="email">
          </li>
          <li><input type="submit" value="Recover"></li>
        </ul>
      </form>
      <?php 
      } else {
        header('Location: index.php');
        exit();
      }
    } //corresponds to else on line 11
  ?>
  
<?php include 'includes\overall\footer.php'; ?>   