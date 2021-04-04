<!-- Archivo predeterminado para taxonomia y tags, es el que se llama si no hay otro mas especifico -->

<?php get_header(); ?>
<div class="container my-4">
    <div class="row">
      <div class="col-12 text-center">
        <h1><?php the_archive_title(); ?></h1>
      </div>
      <!-- funcion que itera por todas las entradas y las imprime -->
      <?php if (have_posts()) { ?>
          <?php while (have_posts()) { ?>
              <?php the_post(); ?>
              <div class="col-4 single-archive">
                  <a href="<?php the_permalink(); ?>">
                      <?php the_post_thumbnail('large'); ?>
                      <h4><?php the_title(); ?></h4>
                  </a>
              </div>
          <?php } ?>
      <?php } ?>
    </div>
</div>
<?php get_footer(); ?>