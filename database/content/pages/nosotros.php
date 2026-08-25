<?php
return [
    'slug'     => 'nosotros',
    'name'     => 'Nosotros',
    'template' => 'about',
    'h1'       => 'Quiénes somos',
    'meta_title'       => 'Nosotros | paginasweb.gt, una marca de Servicom',
    'meta_description' => 'paginasweb.gt es la marca con la que Servicom diseña sitios web en Guatemala desde 2007. Cómo trabajamos, en qué creemos y qué podés esperar de nosotros.',
    'og_image' => '/assets/img/og/og-nosotros.webp',
    'sort_order' => 7,
    'intro'    => 'Somos el equipo de Servicom. paginasweb.gt es la marca con la que atendemos proyectos de sitios y tiendas.',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Nosotros',
            'heading'    => 'Quiénes somos',
            'subheading' => 'paginasweb.gt es la marca comercial con la que Servicom diseña páginas web y tiendas virtuales. Mismo equipo, mismo teléfono, mismo correo y el mismo compromiso desde 2007.',
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'De dónde venimos',
            'body' => <<<'HTML'
<p>Servicom empezó en 2007 haciendo sitios para negocios que en ese momento apenas se estaban preguntando si valía la pena "tener internet". Eran otros tiempos: se diseñaba para pantallas de computadora, casi nadie navegaba desde el teléfono y el correo de la empresa todavía se leía en Outlook Express.</p>
<p>En estos más de 18 años nos tocó adaptarnos varias veces: la llegada del celular como pantalla principal, la exigencia de velocidad, el certificado SSL como requisito, las redes sociales llevándose parte de la conversación y, más recientemente, la búsqueda por voz y los resúmenes automáticos de Google. Lo que no cambió es la parte del trabajo que de verdad decide si un sitio funciona: entender a qué se dedica el cliente y ordenar su información para que otra persona la entienda rápido.</p>
<p>Hemos trabajado con bufetes, importadoras, distribuidoras de equipo industrial, clínicas, empresas de transporte, talleres y consultoras. En el <a href="/portafolio/">portafolio</a> están los sitios que siguen en línea.</p>
HTML,
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Por qué usamos dos marcas',
            'body' => <<<'HTML'
<p>Conviene explicarlo claro, porque nos lo van a preguntar. <strong>Servicom</strong> es la empresa: el nombre con el que facturamos, con el que nos conocen clientes de hace más de una década y bajo el que seguimos atendiendo desde <a href="https://servicom.gt" rel="noopener">servicom.gt</a>. <strong>paginasweb.gt</strong> es la marca con la que presentamos específicamente el servicio de sitios y tiendas, con un nombre que describe lo que hacemos y que a la gente le queda más fácil recordar y dictar por teléfono.</p>
<p>No son dos empresas, ni dos equipos, ni dos listas de precios. Es la misma gente, el mismo número de WhatsApp y el mismo correo. Si nos escribiste a Servicom hace tres años, te contesta la misma persona.</p>
HTML,
        ],
        [
            'block_type' => 'features',
            'eyebrow'    => 'Cómo trabajamos',
            'heading'    => 'Cuatro cosas que hacemos distinto',
            'extra' => [
                'items' => [
                    ['icon' => 'chat', 'title' => '100% remoto, a propósito', 'text' => 'No cobramos visitas ni te hacemos perder medio día en tráfico. Todo se resuelve por WhatsApp, correo y videollamada, y el proyecto avanza más rápido así.'],
                    ['icon' => 'edit', 'title' => 'Escribimos nosotros', 'text' => 'La mayoría de proyectos se atrasan porque el cliente tiene que redactar. Nosotros escribimos con base en lo que nos contás y vos solo corregís.'],
                    ['icon' => 'shield', 'title' => 'Los accesos son tuyos', 'text' => 'Dominio a nombre de tu empresa y entrega de credenciales cuando las pidás. Si un día te querés ir, te ayudamos a irte bien.'],
                    ['icon' => 'search', 'title' => 'Sin humo con el SEO', 'text' => 'Hacemos bien la parte técnica y de contenido, y te explicamos qué depende de nosotros y qué depende del tiempo y de tu competencia.'],
                ],
            ],
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'En qué no creemos',
            'body' => <<<'HTML'
<p>No creemos en inflar cifras. No vas a leer aquí "más de 500 clientes satisfechos" ni un promedio de estrellas que nadie puede verificar. Publicamos el número de sitios que podés abrir y comprobar, y cuando tengamos testimonios de clientes reales dispuestos a firmarlos, los vamos a publicar con nombre y empresa.</p>
<p>Tampoco creemos en las tácticas que dan un salto rápido en Google y un castigo después: llenar el pie de página con nombres de municipios, crear una página casi idéntica por cada palabra clave, comprar enlaces o esconder texto del mismo color que el fondo. Todo eso funcionó hace años y hoy es la forma más rápida de que un dominio nuevo pierda su oportunidad.</p>
HTML,
        ],
        [
            'block_type' => 'cta',
            'heading'    => 'Hablemos de tu proyecto',
            'subheading' => 'Contanos qué hacés y qué querés lograr. Si podemos ayudarte, te lo decimos con precio y tiempo; si no, también.',
            'cta_text'   => 'Escribir por WhatsApp',
            'cta_url'    => 'whatsapp',
            'extra'      => ['cta2_text' => 'Ir a contacto', 'cta2_url' => '/contacto/'],
        ],
    ],
];
