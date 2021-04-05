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


    //se usa para poder enviar la url en Ajax
    wp_localize_script(
        'custom',   //nombre del archivo
        'pg',   //nombre del objeto
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'apiurl' => home_url('/wp-json/pg/v1/')
        )
    );
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



//funcion para crear una taxonomia personalizada
function lstCreateCustomTaxonomies(){

    $taxonomy = array(
        'labels' => array(
            'name'          => _x('Categorías de Productos', 'taxonomy general name', 'ls19'), 
            'singular_name' => _x('Categoría de Productos', 'taxonomy singular name', 'ls19'),
            'search_items'  => __('Buscar categoría'),
            'all_items'     => __('Todas las categorías'),
            'edit_item'     => __('Editar categoría'),
            'update_item'   => __('Actualizar categoría'),
            'add_new_item'  => __('Agregar categoría'),
            'menu_name'     => __('Categorías de Productos')
        ),
        'slug' => 'categorias-productos',
        'post_types' => array('producto')
    );

    $args = array(
        'hierarchical'      => true,    //define si la taxonomia permite crear subcategorias
        'public'            => true,    
        'labels'            => $taxonomy['labels'], //resive las etiquetas que muestra la taxonomia en los espacios del administrador
        'show_ui'           => true,
        'show_in_nav_menus' => true,    //mostrar en el menu de administracion
        'show_admin_column' => true,    //mostrar en la columna del administrador
        'query_var'         => true,
        'rewrite'           => array('slug' => $taxonomy['slug'])   //permite como se reescribe la ruta de los productos
    );

    //funcion para registrar la taxonomia en wordpress
    //resive el slug definido anteriormente, los post type y los argumentos
    register_taxonomy($taxonomy['slug'], $taxonomy['post_types'], $args);
}


//hook para llamar la funcion, despues de setear el tema
add_action('init', 'lstCreateCustomTaxonomies');


//funcion para filtrar
function filtroProductos(){

    //recibe todos los productos y los ordena
    $args = array(
        'post_type' => 'producto',
        'posts_per_page' => -1,
        'order'     => 'ASC',
        'orderby' => 'title',
        'tax_query' => array(
            array(
                'taxonomy' => 'categorias-productos',
                'field' => 'slug',
                'terms' => $_POST['categoria']
            )
        )
    );
    $productos = new WP_Query($args);

    $return = array();
    if ($productos->have_posts()) {
        while($productos->have_posts()){
            $productos->the_post();
            $return[] = array(
                'imagen' => get_the_post_thumbnail(get_the_ID(), 'large'),
                'link' => get_permalink(),
                'titulo' => get_the_title()
            );
        }
    }

    wp_send_json($return);
}



add_action('wp_ajax_nopriv_filtroProductos','filtroProductos');
add_action('wp_ajax_filtroProductos','filtroProductos');