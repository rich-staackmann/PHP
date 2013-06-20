<?php 
  function article_exists($article_id){
    $article_id = (int)$article_id;
    global $db;
    $query = $db->query("SELECT COUNT(article_id) FROM articles WHERE article_id = $article_id");
    return ($query->fetchColumn(0) == 0) ? false : true;
  }
  
  function previously_liked($article_id){
    $article_id = (int)$article_id;
    global $db;
    $query = $db->query("SELECT COUNT(like_id) FROM likes WHERE user_id = ".$_SESSION['user_id']." AND article_id = $article_id");
    return ($query->fetchColumn(0) == 0) ? false : true;
  }
  
  function like_count($article_id) {
    $article_id = (int)$article_id;
    global $db;
    $query = $db->query("SELECT article_likes FROM articles WHERE article_id = $article_id");
    return $query->fetchColumn(0);
  }
  
  function add_like($article_id) {
    $article_id = (int)$article_id;
    global $db;
    $query1 = $db->query("UPDATE articles SET article_likes = article_likes + 1 WHERE article_id = $article_id");
    $query2 = $db->query("INSERT INTO likes (user_id, article_id) VALUES (".$_SESSION['user_id'].", $article_id)");
  }
?>