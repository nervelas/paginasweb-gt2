<?php
return [
    'slug'     => 'cuentas-de-correo-corporativo',
    'name'     => 'Correo corporativo',
    'template' => 'service',
    'h1'       => 'Cuentas de correo corporativo con tu dominio',
    'meta_title'       => 'Correo Corporativo Guatemala con tu Dominio',
    'meta_description' => 'Cuentas de correo con tu propio dominio para empresas de Guatemala: configuración en celular y computadora, SPF y DKIM, y traslado desde otro proveedor.',
    'og_image' => '/assets/img/og/og-correo-corporativo.webp',
    'sort_order' => 5,
    'intro'    => 'Escribile a tus clientes desde tu dominio, no desde una dirección de Gmail.',
    'service_slug' => 'correo-corporativo',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Servicio',
            'heading'    => 'Cuentas de correo corporativo con tu dominio',
            'subheading' => 'Creamos las cuentas con tu propio dominio, las dejamos configuradas en tu celular y en tu computadora, y ordenamos los registros técnicos para que tus mensajes lleguen a la bandeja de entrada y no a la carpeta de spam.',
            'cta_text'   => 'Consultar precio',
            'cta_url'    => 'whatsapp',
            'image'      => '/assets/img/servicio-correo-corporativo.svg',
            'image_alt'  => 'Ilustración de bandeja de correo con dominio propio',
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Por qué importa más de lo que parece',
            'body' => <<<'HTML'
<p>Mandar una cotización de Q40,000 desde una dirección de Gmail con números al final le baja la credibilidad al negocio antes de que el cliente lea el precio. Es injusto, pero pasa. En procesos de compra corporativos, más de una empresa descarta proveedores que no escriben desde su propio dominio, y en instituciones públicas a veces ni siquiera aceptan correos de dominios gratuitos.</p>
<p>Además hay una razón práctica: cuando un colaborador se va, la cuenta corporativa la controlás vos. Con una cuenta personal, se lleva el historial de conversaciones con tus clientes. Hemos visto negocios perder toda la relación con una cuenta grande porque el vendedor manejaba todo desde su correo personal.</p>
HTML,
        ],
        [
            'block_type' => 'features',
            'eyebrow'    => 'Qué incluye',
            'heading'    => 'El servicio completo',
            'extra' => [
                'items' => [
                    ['icon' => 'mail', 'title' => 'Cuentas con tu dominio', 'text' => 'Creamos las direcciones que necesités: personales, de área (ventas, info, cobros) y alias que reenvían a otra cuenta.'],
                    ['icon' => 'phone', 'title' => 'Configuración en tus dispositivos', 'text' => 'Dejamos el correo andando en Android, iPhone, Outlook y el correo de Mac. Con una videollamada resolvemos toda la empresa.'],
                    ['icon' => 'shield', 'title' => 'SPF, DKIM y DMARC', 'text' => 'Los registros que le dicen a Gmail y Outlook que tus correos son legítimos. Sin esto, tus mensajes acaban en spam sin que sepas por qué.'],
                    ['icon' => 'box', 'title' => 'Traslado desde tu proveedor actual', 'text' => 'Si ya tenés correo en otro lado, migramos las cuentas y el historial cuando la plataforma lo permite, con la menor interrupción posible.'],
                    ['icon' => 'browser', 'title' => 'Acceso por navegador', 'text' => 'Webmail desde cualquier computadora, útil cuando estás fuera de la oficina o se dañó el equipo.'],
                    ['icon' => 'edit', 'title' => 'Buenas prácticas', 'text' => 'Te dejamos firmas uniformes para todo el equipo y recomendaciones de respaldo y contraseñas.'],
                ],
            ],
        ],
        [
            'block_type' => 'pricing_service',
            'eyebrow'    => 'Inversión',
            'heading'    => 'Precio del correo corporativo',
            'subheading' => 'El precio depende de cuántas cuentas necesitás y del espacio de cada una. Si contratás una página web con nosotros, las cuentas van incluidas.',
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Correo propio o Google Workspace',
            'body' => <<<'HTML'
<p>Hay dos caminos y los dos son válidos. El correo en tu propio alojamiento es más económico y suficiente para un equipo pequeño que manda y recibe correo normal. Google Workspace o Microsoft 365 cuestan una mensualidad por usuario, pero traen Drive, calendarios compartidos, documentos colaborativos y un filtro de spam mejor.</p>
<p>Nuestra recomendación honesta: si son menos de cinco personas y solo necesitan correo, el alojamiento propio está bien. Si ya comparten archivos, agendan reuniones y trabajan documentos entre varios, conviene pagar la plataforma. Podemos configurar cualquiera de las dos, incluida la parte de DNS que casi siempre es donde se traba la gente.</p>
HTML,
        ],
        [
            'block_type' => 'faq',
            'eyebrow'    => 'Preguntas',
            'heading'    => 'Dudas sobre correo corporativo',
        ],
        [
            'block_type' => 'cta',
            'heading'    => '¿Cuántas cuentas necesita tu empresa?',
            'subheading' => 'Contanos cuántas personas van a usar correo y te pasamos el precio.',
            'cta_text'   => 'Consultar por WhatsApp',
            'cta_url'    => 'whatsapp',
            'extra'      => ['cta2_text' => 'Escribir por formulario', 'cta2_url' => '/contacto/'],
        ],
    ],
];
