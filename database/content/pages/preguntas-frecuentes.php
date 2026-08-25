<?php
return [
    'slug'     => 'preguntas-frecuentes',
    'name'     => 'Preguntas frecuentes',
    'template' => 'faq',
    'h1'       => 'Preguntas frecuentes sobre sitios web',
    'meta_title'       => 'Preguntas Frecuentes sobre Páginas Web | Guatemala',
    'meta_description' => 'Respuestas claras sobre dominios, hosting, tiempos de entrega, pagos, SEO y qué pasa si dejás de renovar tu página web en Guatemala.',
    'og_image' => '/assets/img/og/og-preguntas-frecuentes.webp',
    'sort_order' => 8,
    'intro'    => 'Las dudas que más nos escriben, contestadas sin rodeos.',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Ayuda',
            'heading'    => 'Preguntas frecuentes sobre sitios web',
            'subheading' => 'Juntamos lo que más nos preguntan por WhatsApp en estos años. Si tu duda no está acá, escribinos y la contestamos —y probablemente la agreguemos a esta página.',
        ],
        [
            'block_type' => 'faq_groups',
            'extra' => [
                'groups' => [
                    ['title' => 'Antes de contratar', 'slug' => 'preguntas-frecuentes'],
                    ['title' => 'Precios y pagos', 'slug' => 'precios'],
                    ['title' => 'Páginas web', 'slug' => 'diseno-de-paginas-web-guatemala'],
                    ['title' => 'Tiendas en línea', 'slug' => 'tiendas-virtuales-guatemala'],
                    ['title' => 'Correo corporativo', 'slug' => 'cuentas-de-correo-corporativo'],
                ],
            ],
        ],
        [
            'block_type' => 'cta',
            'heading'    => '¿Tu duda no está en la lista?',
            'subheading' => 'Escribinos y te contestamos en horario de oficina, normalmente el mismo día.',
            'cta_text'   => 'Preguntar por WhatsApp',
            'cta_url'    => 'whatsapp',
            'extra'      => ['cta2_text' => 'Escribir por formulario', 'cta2_url' => '/contacto/'],
        ],
    ],
];
