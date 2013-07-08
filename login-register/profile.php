<?php 
//a sample profile page...sort of bare 
  include 'core\init.php'; 
  include 'includes\head.php'; 
  
  if(isset($_GET['username']) && !empty($_GET['username'])) {
    $username = $_GET['username'];
    if(user_exists($username)) {
      $user_id = user_id_from_username($username);
      $profile_data = user_data($user_id, 'first_name', 'last_name', 'email');
     ?>
      <h1><?php echo $profile_data['first_name']; ?>'s Profile</h1>
      <p><?php echo $profile_data['email']; ?></p>
     <?php 
    } else {
      echo 'Sorry that user does not exist.';
    }
  } else {
    header('Location: index.php');
    exit();
  }
?>
  
<?php include 'includes\overall\footer.php'; ?>   