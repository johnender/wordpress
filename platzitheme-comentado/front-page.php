<!--  estructura de la pagina inicial -->

<?php get_header(); ?>

<main class='container'>
    <?php if(have_posts()){
            while(have_posts()){
                the_post(); ?>
            <h1 class='my-3'><?php the_title(); ?>!!</h1>
            <?php the_content(); ?>

        <?php    }
    }?>

    <!-- contenedor para agregar los productos a la pagina principal -->
    <div class="lista-productos my-5">
        <h2 class='text-center'>PRODUCTOS</h2>
        <div class="row">

            <!-- loop personalizado en php -->
            <?php
            $args = array(
                'post_type' => 'producto',  //tipo de contenido, debe corresponder con el registro
                'post_per_page' => -1,  //define cuantos productos va a traer, con -1 trae todos
                'order'         => 'ASC',   //orden para traer el contenido del loop (el default es descendente por fecha)
                'orderby'       => 'title'
            );

            $productos = new WP_Query($args);

            if($productos->have_posts()){
                while($productos->have_posts()){
                    $productos->the_post();
                    ?>

                    <div class="col-4">
                        <figure>
                            <?php the_post_thumbnail('large'); ?>
                        </figure>
                        <h4 class='my-3 text-center'>
                            <!-- the_permalink() es una funcion de wordpress que devuelve el link correspondiente al producto -->
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title();?>
                            </a>
                        </h4>
                    </div>

                    <?php 
                }
            }

            ?>
      </div>
    </div>
</main>

<?php get_footer(); ?>