<?php 
  include '..\core\init.php';
  
  if(isset($_POST['article_id'], $_SESSION['user_id']) && article_exists($_POST['article_id'])) {
    $article_id = $_POST['article_id'];
    if(previously_liked($article_id) === true){
      echo "You have already liked this!";
    } else {
      add_like($article_id);
      echo 'success';
    }
    
  }
?>