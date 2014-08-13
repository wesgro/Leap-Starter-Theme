<?php 
  $queries = get_responsive_sizes();
  
  $bgsizes = array(
    $queries['pmobile'] => 'bg-slider-pmobile',
    $queries['lmobile'] => 'bg-slider-lmobile',
    $queries['ptab'] => 'bg-slider-ptab' ,
    $queries['ltab'] => 'bg-slider-ltab',
    $queries['desk'] => 'bg-slider-desk',
  );
  $sliders = get_posts(array(
    'post_type' => 'slider'
  , 'numberposts' => 4
  , 'orderby'   => 'menu_order'
  , 'order'     => 'ASC'
  ));
  //print_r($sliders);
?>
<?php if($sliders !== false): ?>
<section class="region l-region--hero" data-snap-ignore="true">
  <div id="main-slider" class="owl-carousel owl-theme">
      <?php foreach($sliders as $slider):?>
        <div class="item">
        <?php
          $bg = get_field('image', $slider->ID);
        ?>
          <div class="wrap">
            <div class="text">
              <h2><?php echo preg_replace('/(?<=\>)\b\w*\b|^\w*\b/', '<b>$0</b>', $slider->post_title); ?></h2>
              <div class="body">
                <?php echo get_field('slider_text', $slider->ID); ?>
              </div>
              <div class="link">
                <a class="button" href="<?php echo get_field('link_url', $slider->ID); ?>"><?php echo get_field('link_text', $slider->ID); ?></a>
              </div>
            </div>
          </div>
          <div class="bg">
            <?php 
              echo leap_picture_fill($bg['id'], $bgsizes); 
            ?>
          </div>
        </div>
      <?php endforeach;?>
  </div>
</section>
<?php endif;?>