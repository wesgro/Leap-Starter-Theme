<div id="mobile-navigation">
  <nav>
    
    <h2><i class="icon-menu"></i> <span class="close-menu">Close</span></h2>
    <?php
      if (has_nav_menu('mobile_navigation')) :
        wp_nav_menu(
          array(
            'container' => false                           // remove nav container
            , 'theme_location' => 'mobile_navigation'
            , 'menu_class' => 'nav navbar-nav'
            ,'walker' => new Mobile_Nav_Walker()
          )
        );
      endif;
    ?>
    <?php get_search_form( true ); ?>
  </nav>
</div>