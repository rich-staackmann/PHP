<?php 
  include '..\core\init.php';
  
  if(isset($_POST['article_id'], $_SESSION['user_id']) && article_exists($_POST['article_id'])) {
    echo like_count($_POST['article_id']);
  }
?>