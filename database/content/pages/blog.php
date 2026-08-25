<?php
return [
    'slug'     => 'blog',
    'name'     => 'Blog',
    'template' => 'blog_index',
    'h1'       => 'Guías sobre sitios web y ventas en línea',
    'meta_title'       => 'Blog de Páginas Web y Tiendas en Línea | Guatemala',
    'meta_description' => 'Guías prácticas para negocios guatemaltecos: precios reales, cómo vender en línea, cobro con tarjeta, dominios .gt y errores al contratar diseño web.',
    'og_image' => '/assets/img/og/og-blog.webp',
    'sort_order' => 10,
    'intro'    => 'Escribimos sobre lo que nos preguntan en las cotizaciones, con datos de Guatemala y sin relleno.',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Blog',
            'heading'    => 'Guías sobre sitios web y ventas en línea',
            'subheading' => 'Publicamos poco y con calma. Cada guía nace de una pregunta que nos hicieron varios clientes, y la escribimos con precios, plataformas y trámites que aplican en Guatemala, no con ejemplos de otro país.',
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Cómo elegimos de qué escribir',
            'body' => <<<'HTML'
<p>Cada guía nace de una conversación real con un cliente. Cuando la misma duda aparece tres o cuatro veces en cotizaciones distintas, sabemos que vale la pena responderla bien y dejarla escrita.</p>
<p>Por eso publicamos poco. No tenemos un calendario que nos obligue a sacar cuatro artículos al mes para alimentar un algoritmo, y no vamos a llenar esta sección de textos genéricos que se podrían haber escrito en cualquier país. Si un tema no lo dominamos, no lo tocamos; y cuando algo cambia —un precio del mercado, una condición de un banco, una regla de la SAT— volvemos sobre el artículo y lo actualizamos en lugar de publicar uno nuevo casi igual.</p>
<p>Lo que sí vas a encontrar acá: montos en quetzales, plataformas que de verdad operan en el país, trámites tal como se hacen localmente y advertencias sobre lo que hemos visto salir mal. Y cuando la respuesta honesta a una pregunta es «no te conviene contratarlo», eso también lo escribimos, aunque vaya en contra de vendernos.</p>
<p>Tampoco encontrarás listas de «los 20 mejores complementos» ni resúmenes de noticias que ya leíste en otro lado. Ese tipo de contenido se produce en volumen porque es fácil, no porque le sirva a alguien. Nuestro criterio para publicar es sencillo: si un dueño de negocio puede tomar una mejor decisión después de leer el texto, vale la pena; si solo va a quedarse con la sensación de haber leído algo, no.</p>
<p>Si tenés una pregunta que no está resuelta en ninguna de estas guías, escribinos. Contestamos por WhatsApp aunque no seas cliente, y si la duda se repite lo suficiente, termina convertida en el siguiente artículo. Buena parte de lo que está publicado acá empezó exactamente así, en una conversación de cotización que se alargó porque valía la pena explicarlo bien.</p>
HTML,
        ],
        [
            'block_type' => 'features',
            'eyebrow'    => 'Índice',
            'heading'    => 'Qué vas a encontrar en cada guía',
            'extra' => [
                'items' => [
                    ['icon' => 'chart', 'title' => 'Precios del mercado', 'text' => 'Los rangos que se manejan hoy, qué justifica cada salto de precio y las preguntas que hay que hacer antes de aceptar una cotización.'],
                    ['icon' => 'cart', 'title' => 'Vender en línea', 'text' => 'Desde decidir si tu negocio está listo hasta configurar envíos, formas de pago y la emisión de comprobantes.'],
                    ['icon' => 'card', 'title' => 'Cobros con tarjeta', 'text' => 'Cómo funciona la afiliación bancaria, qué comisiones esperar y por qué a veces conviene esperar antes de activarla.'],
                    ['icon' => 'search', 'title' => 'Dominios y hosting', 'text' => 'Qué extensión conviene, a nombre de quién debe quedar registrada y qué pasa el día que decidís cambiar de proveedor.'],
                    ['icon' => 'shield', 'title' => 'Antes de contratar', 'text' => 'Las cláusulas y omisiones que salen caras después, con una lista de verificación de nueve puntos para revisar cualquier propuesta.'],
                    ['icon' => 'edit', 'title' => 'Decisiones de plataforma', 'text' => 'Comparaciones con números a tres años, no con opiniones: qué te conviene según cómo vendés y quién va a administrar el sitio.'],
                ],
            ],
        ],
    ],
];
