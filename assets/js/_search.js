$(function(){
  $('.l-region--search a').click(function(e){
    $(".search-feature").velocity({left:0},800,'easeOutCubic');
    e.preventDefault();
  });
  $('button.close-search').click(function(e){
    $(".search-feature").velocity({left:'200%'},800,'easeOutCubic');
    e.preventDefault();
  });
  
});