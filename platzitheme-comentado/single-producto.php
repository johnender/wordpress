<!-- hace referencia a los productos -->

<?php get_header(); ?>

<main class='container my-3'>

<!-- loop quie revisa si hay info para mostrar y la va mostrando -->
    <?php if(have_posts()){
            while(have_posts()){
                the_post();
            ?>
                <!-- my es de bootstart, margin eje y -->
                <h1 class='my-5'>Este producto es: <?php the_title() ?></h1>
                <div class="row align-items-center">
                    <div class="col-6">
                        <!--  funcion para buscar el tumbnail y definirle el tamanho -->
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                    <div class="col-6">
                        <?php the_content(); ?>
                    </div> 
                </div>

                <!-- buscar id del producto actual -->
                <?php $ID_producto_actual = get_the_ID(); ?>

                <!-- establece los argumentos que va a buscar y como -->
                <?php $args = array(
                    'post_type' => 'producto',
                    'posts_per_page' => -1,
                    'post__not_in'   => array($ID_producto_actual),
                    'order'     => 'ASC',
                    'orderby' => 'title'
                );

                //trae las entradas
                $productos = new WP_Query($args); ?>


                <!-- muestra todas las entradas -->
                <?php if ($productos->have_posts()) { ?>
                    <div class="row text-center justify-content-center productos-relacionado my-2">
                        <div class="col-12">
                            <h3>Productos relacionados</h3>
                        </div>
                        <?php while($productos->have_posts()) { ?>
                            <?php $productos->the_post(); ?>
                            <div class="col-md-2 col-12 my-3 text-center">
                                <figure><?php the_post_thumbnail('thumbnail'); ?></figure>
                                <h4 class='my-2'>
                                    <a href="<?php the_permalink();?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>


            <?php
            }
    } ?>

</main>
<?php get_footer(); ?>