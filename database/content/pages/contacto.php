<?php
return [
    'slug'     => 'contacto',
    'name'     => 'Contacto',
    'template' => 'contact',
    'h1'       => 'Contacto y cotización',
    'meta_title'       => 'Contacto | Cotizá tu Página Web en Guatemala',
    'meta_description' => 'Escribinos por WhatsApp o dejanos tus datos y te enviamos una propuesta con precio y tiempo de entrega. Atención en línea para toda Guatemala.',
    'og_image' => '/assets/img/og/og-contacto.webp',
    'sort_order' => 9,
    'intro'    => 'Contanos qué necesita tu negocio y te respondemos con una propuesta concreta.',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Hablemos',
            'heading'    => 'Contacto y cotización',
            'subheading' => 'La forma más rápida es WhatsApp. Si preferís dejar todo por escrito, el formulario nos da la información completa desde el inicio y te respondemos con una propuesta, no con un "gracias por escribir".',
        ],
        [
            'block_type' => 'contact_form',
            'heading'    => 'Pedí tu cotización',
            'subheading' => 'Mientras más nos contés, más concreta será la respuesta.',
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Qué nos ayuda a darte una respuesta concreta',
            'body' => <<<'HTML'
<p>No hace falta que tengás todo resuelto para escribirnos. Pero si podés adelantarnos estas cuatro cosas, la propuesta que te mandemos va a ser mucho más precisa y nos ahorramos dos o tres idas y venidas:</p>
<ul>
  <li><strong>A qué se dedica tu negocio y a quién le vende.</strong> No el rubro general, sino lo concreto: si vendés equipo industrial, a qué tipo de empresa; si sos despacho, en qué áreas trabajás de verdad.</li>
  <li><strong>Qué te preguntan siempre tus clientes.</strong> Abrí tu WhatsApp y contanos las cinco preguntas que más repetís. De ahí sale la estructura del sitio.</li>
  <li><strong>Qué material ya tenés.</strong> Logotipo en buena calidad, fotografías propias, listado de servicios o productos, textos que ya usás en presentaciones. Si no tenés nada, también está bien: te decimos qué conseguir.</li>
  <li><strong>Si ya tenés dominio o sitio.</strong> Si tu página actual ya tiene visitas, conviene migrarla con cuidado para no perder el posicionamiento acumulado.</li>
</ul>
<p>Y si lo que tenés es una cotización de otro proveedor y querés una segunda opinión, mandanosla. La revisamos y te decimos si el precio es razonable para lo que ofrece, aunque después contratés con ellos. Preferimos eso a que alguien pague de más por algo que no le va a servir.</p>
HTML,
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Lo que no hacemos',
            'body' => <<<'HTML'
<p>Para ahorrarte tiempo: no desarrollamos aplicaciones móviles, no hacemos sistemas contables ni de inventario a la medida, no gestionamos campañas de publicidad pagada y no manejamos redes sociales. Nos dedicamos a sitios web, tiendas en línea y correo corporativo, y preferimos hacer bien eso a estirarnos hacia servicios donde no somos los mejores.</p>
<p>Si tu proyecto necesita algo de esa lista, decinos igual: casi siempre podemos orientarte sobre qué buscar y qué preguntas hacerle a quien lo vaya a hacer.</p>
HTML,
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Qué pasa después de que nos escribís',
            'body' => <<<'HTML'
<p>Primero leemos con calma lo que nos mandaste y, si hace falta, te hacemos dos o tres preguntas para entender bien el negocio. Después te enviamos una propuesta con tres cosas claras: qué secciones tendría tu sitio, cuánto cuesta y en cuánto tiempo lo entregamos. Si nos escribís por la tarde, lo normal es que tengas respuesta al día siguiente hábil.</p>
<p>No hacemos seguimiento insistente. Si te interesa, seguimos; si no, ahí queda y podés escribirnos cuando quieras. Y si nos preguntás por algo que no hacemos —una aplicación móvil, un sistema contable, publicidad pagada— te lo decimos de una vez en lugar de estirar la conversación.</p>
HTML,
        ],
    ],
];
