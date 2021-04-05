import { registerBlockType } from '@wordpress/blocks';

registerBlockType(
    'pg/basic', //nombre del bloque
    {
        title: "Basic Block",
        description: "Este es nuestro primer bloque",
        icon: "smiley",
        category: "layout",
        edit: () => <h2>Hello World</h2>,   //funcion para mostrar como se va a ver en el editor
        save: () => <h2>Hello World</h2>    //lo que procesa el front
    }
);