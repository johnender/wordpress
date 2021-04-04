<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- trae todas las funciones de wordpress para el encabezado, se coloca en vez del titulo -->
    <?php wp_head() ?>
</head>
<body>

<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4">
                <!-- se usa la etiqueta de php para llamar una funcion php que devuelve la direccion -->
                <img src="<?php echo get_template_directory_uri()?>/assets/img/logo.png" alt="logo">
            </div>
            <div class="col-8">
                <nav>
                    <!-- funcion de wordpress para imprimir el menu -->
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'top_menu', //top_menu es la localizacion establecida en functions.php
                            'menu_class'    => 'menu-principal', //clase del ul del nav
                            'container_class' => 'container-menu', //clase del contenedor (esta antes del menu_class)
                        )
                    ); 
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>
    
