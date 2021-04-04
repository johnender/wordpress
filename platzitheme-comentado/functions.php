<?php 

function init_template(){

    add_theme_support('post-thumbnails');//permite mostart imagenes destacadas
    add_theme_support( 'title-tag'); //imprime en el header el titulo de la pagina

    //agrega la opcion de menus para el administrador de wordpress (en la pestanha de apariencia)
    //con 'Menú Principal' como la localizacion del menu
    register_nav_menus(
        array(
            'top_menu' => 'Menú Principal'
        )
    );

}

add_action('after_setup_theme', 'init_template'); //hook para llamar la funcion y que se ejecute despues de establecer el tema

function assets(){

    //wp_register_style(name, source, dependencies, version, afected files)

    //hook para registrar las librerias como dependencias (para que carguen antes que el archivo de estilos)
    wp_register_style('bootstrap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', '', '4.4.1','all');
    wp_register_style('montserrat', 'https://fonts.googleapis.com/css?family=Montserrat&display=swap','','1.0', 'all');

    //para ejecutar las dependencias anteriores antes que el archivo de estilos
    wp_enqueue_style('estilos', get_stylesheet_uri(), array('bootstrap','montserrat'),'1.0', 'all');
   
    wp_register_script('popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js','','1.16.0', true);
    //se usa el mismo handle, pero no se pisa, ya que uno es de estilos y el otro de script
    wp_enqueue_script('boostraps', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','popper'),'4.4.1', true);
    wp_enqueue_script('custom', get_template_directory_uri().'/assets/js/custom.js', '', '1.0', true);
}

add_action('wp_enqueue_scripts','assets'); //hook para llamar la funcion cuando comienza a cargar la pagina


//funcion para registrar el widget, el cual habilita la opcion en el administrador de wordpress, para usarlo hay que ir a agregar los widgets, esta funcion solo da la localizacion
function sidebar(){
    register_sidebar(
        array(
            'name' => 'Pie de página',
            'id'   => 'footer',
            'description' => 'Zona de Widgets para pie de página',
            'before_title' => '<p>',
            'after_title'  => '</p>',
            'before_widget' => '<div id="%1$s" class="%2$s">',//asigna valores automaticamente
            'after_widget'  => '</div>',
        )
        );
}

//hook para cargar la funcion al codigo fuente de wordpress
add_action('widgets_init', 'sidebar');

function productos_type(){
    $labels = array(
        'name' => 'Productos',
        'singular_name' => 'Producto',
        'menu_name' => 'Productos',
    );

    $args = array(
        'label'  => 'Productos', //mensaje predeterminado a mostrar
        'description' => 'Productos de Johnn',
        'labels'       => $labels,  //otros valores a agregar
        'supports'   => array('title','editor','thumbnail', 'revisions'),   //establece las opciones que puede usar, revisions permite el manejo de versiones
        'public'    => true,    //establecer si las entradas aparecen como publicadas o borrador
        'show_in_menu' => true, //mostrar en el menu del administrador de wordpress
        'menu_position' => 5,   //posicion del menu
        'menu_icon'     => 'dashicons-cart',    //has de icono en wordpress
        'can_export' => true,   //para exportar el contenido
        'publicly_queryable' => true,   //para poder llamarlo con un loop personalizado
        //necesarios para utilizart el editor de gutenberg
        'rewrite'       => true,    //da una url asignada para la entrada
        'show_in_rest' => true  //hace que los datos del post pertenecezcan al API

    );    
    //funcion para crear el tipo de post, revise el nombre del post type y todos los detalles o configuraciones del post type
    register_post_type('producto', $args);
}

//hook para llamar la funcion, despues de setear el tema
add_action('init', 'productos_type'); 