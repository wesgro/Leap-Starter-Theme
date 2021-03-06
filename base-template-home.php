<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->
  <div class="l-page">
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <?php get_template_part('templates/slider-header');?>
    <section class="l-region--content" role="document">
      <main class="main <?php echo roots_main_class(); ?> wrap" role="main">
        <?php include roots_template_path(); ?>
      </main><!-- /.main -->
  </section>
  <?php get_template_part('templates/postscript'); ?>
  <?php get_template_part('templates/footer'); ?>
  <?php get_template_part('templates/navigation', 'mobile'); ?>

</body>
</html>
