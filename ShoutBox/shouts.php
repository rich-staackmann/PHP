<?php 
  require 'connect.php';
  global $db;
  
  $q = $db->query("SELECT users.username, shouts.user_id, shouts.message, shouts.name
                    FROM users
                    INNER JOIN shouts ON users.id = shouts.user_id
                    ORDER BY shouts.id DESC
                    LIMIT 20");
  $shouts = array();
  while($r = $q->fetch(PDO::FETCH_ASSOC)) {
    $shouts[] = array('user_id' => $r['user_id'], 'username' => $r['username'], 'message' => $r['message'], 'name' => $r['name']);
  }
  foreach ($shouts as $s){
    $user = ($s['user_id'] > 0) ? $s['username'] : $s['name'];
    echo $user.'-'.$s['message'].'<br>';
  }
?>