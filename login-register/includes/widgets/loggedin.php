<div class="widget">
    <h2><?php echo 'Hello ', $user_data['first_name'], '!'; ?></h2>
    <div class="inner">
      <form action="login.php" method="post">
        <ul>
          <li><a href="logout.php">Log out</a></li>
          <?php if(has_access($session_user_id, 1)){ echo '<li><a href="admin.php">Admin Page</a></li>';}?>
          <li><a href="profile.php?username=<?php echo $user_data['username'];?>">Profile Page</a></li>
          <li><a href="changepassword.php">Change your password</a></li>
          <li><a href="settings.php">Edit your account settings</a></li>
        </ul>
      </form>
    </div>
</div>