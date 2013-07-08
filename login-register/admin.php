<?php 
  include 'core\init.php'; 
  protect_page();
  admin_protect();
  include 'includes\head.php'; 
  if(isset($_GET['type']) && isset($_GET['username']) && !empty($_GET['username'])){
    if(user_exists($_GET['username'])) {
      change_privilege($_GET['username'], $_GET['type']);
      echo'<p>We have changed that user\'s privilege level.</p>';
    } else {
      echo '<p>Sorry we could not do that.</p>';
    }
  }
?>

  <h1>Admin Page</h1>
  <p>Select a user to give elevated privilege to.</p>
  <form action="" method="get">
    <ul>
      <li>
        <label for="username">Username:<br></label>
        <input type="text" name="username">
      </li>
      <li>
        <label for="mod">Moderator:</label>
        <input type="radio" id="mod" name="type" value="2" /><br>
        <label for="admin">Admin:</label>
        <input type="radio" id="admin" name="type" value="1" /><br>
        <label for="user">User:</label>
        <input type="radio" id="user" name="type" value="0" />
      </li>
      <li>
        <input type="submit">
      </li>
    </ul>
  </form>
  
<?php include 'includes\overall\footer.php'; ?> 