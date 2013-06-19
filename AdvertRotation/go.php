<?php 
  $dsn = 'mysql:host=localhost;dbname=advertrotation';
  $username = 'root';
  $password = '';
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  if(isset($_GET['advert_id'])) {
    $advert_id = (int)$_GET['advert_id'];
   
    $db->query("UPDATE `adverts` SET `clicks` = `clicks` + 1 WHERE `advert_id` = $advert_id");
    
    $url_query = $db->query("SELECT `url` FROM `adverts` WHERE `advert_id` = $advert_id");
    $url = $url_query->fetchColumn(0);
    
    header('Location: '.$url);
    die();
  }
?>