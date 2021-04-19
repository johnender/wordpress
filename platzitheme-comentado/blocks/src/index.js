import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { TextControl, PanelBody, PanelRow } from '@wordpress/components';

import ServerSideRender from '@wordpress/server-side-render'; // Esta librería está disponible desde que instalamos el paquete "wordpress/scripts" desde NPM

registerBlockType('pg/basic', {
	title: 'Basic Block',
	description: 'Este bloque no tiene ninguna funcionalidad, simplemente es un Hello World.',
	icon: 'smiley',
	category: 'text',
    keywords: [ 'wordpress', 'gutenberg', 'platzigift'],
    attributes: {
		content: {
			type: 'string',
			default: 'Hello world'
		}
	},
	edit: (props) => {
		const { attributes: { content }, setAttributes, className } = props;
		const handlerOnChangeTextControl = (newContent) => {
			setAttributes( { content: newContent } )
		}
		return <>
            <InspectorControls>
                <PanelBody
                    title="Modificar texto del Bloque Básico"
                    initialOpen={ false }
                >
                    <PanelRow>
                        <TextControl
                            label="Complete el campo"
                            value={ content }
                            onChange={ handlerOnChangeTextControl }
                        />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <ServerSideRender // Renderizado de bloque dinámico
                block="pg/basic" // Nombre del bloque
                attributes={ props.attributes } // Se envían todos los atributos
            />
            <h2>{content}</h2>
        </>
	},
	save: () => null
});