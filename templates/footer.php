<footer class="l-region--footer" role="contentinfo">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
  </div>
</footer>
<div id="mobile-navigation">
  <nav>
    
    <h2><i class="icon-menu"></i></h2>
    <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(
          array(
            'container' => false                           // remove nav container
            , 'theme_location' => 'primary_navigation'
            , 'menu_class' => 'nav navbar-nav'
            ,'walker' => new Mobile_Nav_Walker()
          )
        );
      endif;
    ?>
    <?php get_search_form( true ); ?>
  </nav>
</div>
<?php get_template_part( 'templates/searchform', 'overlay' ); ?>
<script>
!function(){for(var a,b=function(){},c=["assert","clear","count","debug","dir","dirxml","error","exception","group","groupCollapsed","groupEnd","info","log","markTimeline","profile","profileEnd","table","time","timeEnd","timeline","timelineEnd","timeStamp","trace","warn"],d=c.length,e=window.console=window.console||{};d--;)a=c[d],e[a]||(e[a]=b)}();
</script>
<?php wp_footer(); ?>
