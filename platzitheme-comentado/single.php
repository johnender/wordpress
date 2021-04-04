<!-- hace referencia a las entradas del blog y para los custom post type -->

<?php get_header(); ?>

<main class='container my-3'>

<!-- loop quie revisa si hay info para mostrar y la va mostrando -->
    <?php if(have_posts()){
            while(have_posts()){
                the_post();
            ?>
                <!-- my es de bootstart, margin eje y -->
                <h1 class='my-5'><?php the_title() ?></h1>
                <div class="row align-items-center">
                    <div class="col-6">
                        <!--  funcion para buscar el tumbnail y definirle el tamanho -->
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                    <div class="col-6">
                        <?php the_content(); ?>
                    </div> 
                </div>
            <?php
            }
    } ?>

</main>
<?php get_footer(); ?>