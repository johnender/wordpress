<!--  vista predeterminada para los post type -->

<?php get_header(); ?>
<!-- pasando el header del tema -->

<main class='container'>
    <?php if(have_posts()){     //revisa si hay informacion para mostrar
            while(have_posts()){
                //la funcion the_post() muestra el contenido y ademas instancia cada vuelta del loop (suma y al final da false)
                the_post(); ?>  

                <!-- se usan las funciones de wordpress que devuelven el titulo y el contenido -->
            <h1 class='my-3'><?php the_title(); ?></h1>

            <?php the_content(); ?>

         <?php }
    }?>
</main>

<?php get_footer(); ?>
<!-- pasando el footer del tema -->