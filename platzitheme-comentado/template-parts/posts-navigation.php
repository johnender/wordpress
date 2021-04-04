<!--  lo siguiente es para dar navegabilidad a la pagina -->

<!--  en una nueva fila para separarla del resto de contenido -->
<div class="row my-5">
    <div class="col-6">
        <!-- llama al post previo del que estamos viendo -->
        <?php previous_post_link(); ?> 
    </div>
    <div class="col-6 text-right">
        <!-- llama al post siguiente del que estamos viendo -->
        <?php next_post_link(); ?>
    </div>
</div>