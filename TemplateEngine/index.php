<?php
  include 'template.php';
  
  $template = new Template;
  $template->assign('username', 'Rich');
  $template->assign('age',18);
  $template->assign('fav_food','noodles');
  
  $template->render('myTemplate');
?>