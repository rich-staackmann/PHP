function like_add(article_id)
{
  $.post('ajax/like_add.php', {article_id:article_id}, function(data){
    if(data == 'success'){
      like_get(article_id);
    } else {
      alert(data);
    }
  });
}

function like_get(article_id)
{
  $.post('ajax/like_get.php', {article_id:article_id}, function(data){
    $('#article_'+article_id+'_likes').text(data);
  });
}