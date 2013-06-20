<?php 
  include 'C:\wamp\www\udemy_php_tut\likeButton\core\init.php';
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Articles</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <?php 
      
      $articles = get_articles();
      if(count($articles) == 0) {
        echo 'Sorry, no articles to show.';
      } else {
        echo '<ul>';
        foreach($articles as $article) {
          echo '<li><p>', $article['article_title'], '</p><p><a href="#" class="like" onclick="like_add(', $article['article_id'], ');">Like</a> <span id="article_', $article['article_id'], '_likes">', $article['article_likes'], '</span> like this article</p></li>';
        }
        echo '</ul>';
      }
    ?>
    <script type="text/javascript" src="js\jquery.js"></script>
    <script type="text/javascript" src="js\like.js"></script>
  </body>
</html>