<?php 
  $feed_url = 'http://www.php.net/feed.atom';
  $feed = simplexml_load_file($feed_url);
  $limit = 10;
  
  $x = 1;
  echo '<ul>';
  foreach($feed->entry as $item) {
    if($x <= $limit) {
      $title = $item->title;
      $url = $item->id;
      
      echo '<li><a href="'.$url.'">'.$title.'</a></li>';
    }
    $x++;
  }
  echo '</ul>';
?>