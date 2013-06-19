<?php 
  $dsn = 'mysql:host=localhost;dbname=advertrotation';
  $username = 'root';
  $password = '';
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $ads = $db->query("SELECT `advert_id`, `image` FROM `adverts` WHERE UNIX_TIMESTAMP() < `expires` AND `shown` = 0 ORDER BY `advert_id` ASC  LIMIT 1");

  while($ads_row = $ads->fetch(PDO::FETCH_ASSOC)){
    $advert_id = $ads_row['advert_id'];
    $image = $ads_row['image'];
    echo '<a href="go.php?advert_id='.$advert_id.'"><img src="'.$image.'" /></a>';
    
    $db->query("UPDATE `adverts` SET `shown` = 1, `impressions` = `impressions` + 1 WHERE `advert_id` = $advert_id");
    
    $shown = $db->query("SELECT COUNT(`advert_id`) FROM `adverts` WHERE `shown` = 0");
    if($shown->fetchColumn(0) == 0) {
      $db->query("UPDATE `adverts` SET `shown` = 0");
    }
  }
?>