<?php 
  function protect($str){
    $str = mysql_real_escape_string($str);
    $str = htmlentities($str, ENT_QUOTES);
    $str = trim($str);
    
    return $str;
  }
?>