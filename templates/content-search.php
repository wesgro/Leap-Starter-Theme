<?php

  $content = get_field('content');
  $search = false;
  $words = '';
  if(is_array($content)){
    foreach($content as $text){
      $search .= $text['body'];
    }
  }
  if($search === false){
    $words = leap_truncatePreserveWords(get_the_excerpt(), get_search_query(), 5, 'strong');
  }
  if($search !== false){
    $words = leap_truncatePreserveWords($search, get_search_query(), 5, 'strong');
  }
?>
<article class="search-result">
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  <div class="entry-summary">
    <?php 
    if(strlen($words) > 3){
      echo $words; 
    }
    ?>
  </div>
</article>
