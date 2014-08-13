<header class="l-region--header" role="banner">
  <div class="wrap">
    <div class="l-region--branding">
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    </div>
    <div class="l-region--meta">
      <div class="items">
        <a href="/contact-us">Contact Us</a> <a href="#" class="menu-toggle">Menu</a>
      </div>
    </div>
    <nav class="l-region--navigation" role="navigation">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
        endif;
      ?>
    </nav>
    <div class="l-region--search">
      <a href="#"><i class="icon-fontawesome-webfont-20"></i></a>
    </div>
  </div>
</header>
