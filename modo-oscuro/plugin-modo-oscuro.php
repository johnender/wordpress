<?php 

//Plugin name: Dark mode
//Description: Activa el modo oscuro de tu theme
//version: 1.0
//Author: Johnn Hernandez
//Author Uri: https://github.com/johnender/


//se pueden utilizar las mismas funciones que en el functions del tema



function estilos_plugin(){
    $estilos_url = plugin_dir_url(__FILE__);//devuelve la direccion URL de este archivo 


    wp_enqueue_style( 'modo_oscuro', $estilos_url."/assets/css/estilos.css", '', '1.0','all');
}




add_action('wp_enqueue_scripts','estilos_plugin');