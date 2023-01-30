<?php
get_header();

$args = get_fields();
?>

<div class="container">
  <?php if (function_exists('simple_breadcrumb')) {
    simple_breadcrumb();
  }
  ?>
  <div class="single-page">
    <h1><?= the_title(); ?></h1>
    <?= the_content(); ?>
  </div>

</div>

<?php get_footer(); ?>