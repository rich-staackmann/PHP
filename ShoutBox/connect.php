<?php 
  $dsn = 'mysql:host=localhost;dbname=shoutbox';
  $username = 'root';
  $password = '';
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>