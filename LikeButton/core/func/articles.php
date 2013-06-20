<?php
  function get_articles() {
    $articles = array();
    global $db;
    $query = $db->query("SELECT `article_id`, article_title, article_likes FROM articles");
    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
      $articles[] = array('article_id' => $row['article_id'], 'article_title' => $row['article_title'], 'article_likes' => $row['article_likes']);
    }
    return $articles;
  }
?>