<?php
return [
    'slug'     => 'portafolio',
    'name'     => 'Portafolio',
    'template' => 'portfolio',
    'h1'       => 'Portafolio de sitios web',
    'meta_title'       => 'Portafolio: 24 sitios web hechos en Guatemala',
    'meta_description' => 'Sitios web que diseñamos para empresas guatemaltecas: bufetes, distribuidoras, clínicas, transporte y servicios. Todos en línea y abiertos para revisar.',
    'og_image' => '/assets/img/og/og-portafolio.webp',
    'sort_order' => 6,
    'intro'    => 'Sitios reales, publicados y funcionando. Abrilos y revisá cómo se ven en tu celular.',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Trabajos',
            'heading'    => 'Portafolio de sitios web',
            'subheading' => 'Preferimos mostrar sitios en línea antes que capturas de diseños que nunca se publicaron. Estos son proyectos de clientes que siguen activos: abrilos, probalos en tu teléfono y fijate en los tiempos de carga.',
        ],
        [
            'block_type' => 'rich_text',
            'body' => <<<'HTML'
<p>Verás sectores muy distintos: despachos legales, distribuidoras industriales, servicios a domicilio, transporte, salud y consultoría. Eso es a propósito. Un sitio de plomería de emergencia y el sitio de un bufete corporativo no se parecen en nada, porque la persona que llega a cada uno está en un momento distinto: una necesita el número ya, la otra quiere verificar trayectoria antes de escribir.</p>
<p>En la mayoría de estos proyectos hicimos también la redacción de los textos, la preparación de las fotos y la configuración de dominio, correos y analítica. Si querés que te contemos cómo resolvimos alguno en particular, preguntanos y con gusto te explicamos las decisiones.</p>
<p class="lead" style="font-size:.95rem;color:var(--ink-50)">Una aclaración: las imágenes de esta página son presentaciones ilustrativas de cada proyecto, no capturas automáticas. El enlace de cada tarjeta lleva al sitio real, que es donde conviene revisarlo.</p>
HTML,
        ],
        [
            'block_type' => 'portfolio_grid',
            'heading'    => 'Sitios publicados',
            'extra'      => ['limit' => 0, 'grid' => true],
        ],
        [
            'block_type' => 'cta',
            'heading'    => '¿Te gustaría ver tu negocio en esta lista?',
            'subheading' => 'Contanos qué hacés y te proponemos la estructura que le sirve a tu tipo de negocio.',
            'cta_text'   => 'Escribir por WhatsApp',
            'cta_url'    => 'whatsapp',
            'extra'      => ['cta2_text' => 'Pedir cotización', 'cta2_url' => '/contacto/'],
        ],
    ],
];
