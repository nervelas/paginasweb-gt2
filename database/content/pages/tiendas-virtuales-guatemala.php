<?php
return [
    'slug'     => 'tiendas-virtuales-guatemala',
    'name'     => 'Tiendas virtuales',
    'template' => 'service',
    'h1'       => 'Tiendas virtuales en Guatemala',
    'meta_title'       => 'Tiendas Virtuales en Guatemala | WooCommerce y tarjeta',
    'meta_description' => 'Tiendas en línea con WooCommerce para Guatemala: catálogo, envíos, cobro con tarjeta por Visanet Epay y panel propio. Q1,750 al año, antes Q3,600.',
    'og_image' => '/assets/img/og/og-tiendas-virtuales.webp',
    'sort_order' => 3,
    'intro'    => 'Vendé desde tu propio dominio, con carrito, envíos por departamento y cobro con tarjeta.',
    'service_slug' => 'tiendas-virtuales',
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Servicio',
            'heading'    => 'Tiendas virtuales en Guatemala',
            'subheading' => 'Montamos tu tienda sobre WooCommerce con el catálogo cargado, opciones de envío para el interior y la posibilidad de cobrar con tarjeta a través de Visanet Epay. Vos administrás productos, precios y pedidos.',
            'cta_text'   => 'Quiero mi tienda',
            'cta_url'    => 'whatsapp',
            'image'      => '/assets/img/servicio-tiendas-virtuales.svg',
            'image_alt'  => 'Ilustración de una tienda en línea con carrito de compras',
            'extra'      => ['cta2_text' => 'Ver precio', 'cta2_url' => '/precios/'],
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Cuándo conviene una tienda y cuándo no',
            'body' => <<<'HTML'
<p>Una tienda en línea tiene sentido cuando vendés productos con precio definido, tenés existencias que podés controlar y ya estás recibiendo pedidos por mensaje. Si vendés servicios que se cotizan caso por caso, o si tu catálogo cambia de precio cada semana según el tipo de cambio, probablemente te sirva más una página web con catálogo y cotización que una tienda con carrito.</p>
<p>Lo decimos antes de venderte: una tienda mal usada es peor que no tenerla. Un carrito con existencias desactualizadas genera pedidos que no podés cumplir, y eso cuesta clientes. Por eso, en la primera conversación revisamos cuántos productos tenés, quién va a mantener el inventario y cómo hacés los envíos hoy. Si la respuesta es que nadie tiene tiempo de actualizar nada, te proponemos empezar con un catálogo sin carrito.</p>
<p>Cuando sí conviene, la diferencia se nota rápido: el cliente arma su pedido solo, ve el costo del envío antes de confirmar, y a vos te llega el pedido completo con dirección y forma de pago, en vez de una conversación de cuarenta mensajes.</p>
HTML,
        ],
        [
            'block_type' => 'features',
            'eyebrow'    => 'Qué incluye',
            'heading'    => 'Lo que lleva tu tienda desde el día uno',
            'extra' => [
                'items' => [
                    ['icon' => 'cart', 'title' => 'WooCommerce sobre WordPress', 'text' => 'La plataforma de comercio más usada del mundo, instalada en tu propio alojamiento. Sin comisión por venta ni renta mensual de plataforma.'],
                    ['icon' => 'box', 'title' => 'Catálogo cargado por nosotros', 'text' => 'Subimos tus primeros productos con categorías, fotos, descripciones, precios, variantes (talla, color, presentación) y control de existencias.'],
                    ['icon' => 'truck', 'title' => 'Envíos configurados para Guatemala', 'text' => 'Tarifas distintas para la capital y el interior, retiro en tienda y envío gratis a partir de cierto monto, si así lo querés manejar.'],
                    ['icon' => 'card', 'title' => 'Formas de pago locales', 'text' => 'Depósito o transferencia bancaria con carga de comprobante, pago contra entrega y, opcionalmente, tarjeta con Visanet Epay.'],
                    ['icon' => 'phone', 'title' => 'Optimizada para el celular', 'text' => 'La mayoría de las compras en Guatemala se hacen desde el teléfono. El proceso de compra está pensado para completarse con una mano.'],
                    ['icon' => 'edit', 'title' => 'Panel para tu equipo', 'text' => 'Agregar productos, cambiar precios, ver pedidos y marcar entregas. Con capacitación por videollamada incluida.'],
                    ['icon' => 'chat', 'title' => 'WhatsApp como respaldo', 'text' => 'Botón visible en todo el sitio, porque en Guatemala mucha gente quiere confirmar por mensaje antes de pagar.'],
                    ['icon' => 'chart', 'title' => 'Medición de ventas', 'text' => 'Configuramos la analítica para que sepas qué productos se ven más y en qué paso se caen los pedidos.'],
                ],
            ],
        ],
        [
            'block_type' => 'rich_text',
            'heading'    => 'Cobro con tarjeta en Guatemala: cómo funciona de verdad',
            'body' => <<<'HTML'
<p>Esta es la parte que más confunde, así que vale explicarla con calma. Para cobrar con tarjeta en tu sitio intervienen tres cosas distintas: la tienda, la pasarela y el banco.</p>
<p>La <strong>tienda</strong> es tu sitio con WooCommerce. La <strong>pasarela</strong> es el servicio que procesa la tarjeta de forma segura sin que los datos pasen por tu servidor: en Guatemala, la opción más usada es Visanet Epay. Y el <strong>banco adquirente</strong> es quien te afilia al servicio, define tu comisión por transacción y deposita el dinero en tu cuenta.</p>
<p>Nosotros hacemos la parte técnica: integramos Epay a tu tienda, configuramos el ambiente de pruebas, hacemos compras de prueba y dejamos el cobro funcionando. Ese trabajo tiene un costo adicional de Q750 al año, que cubre la integración y su mantenimiento. Lo que no podemos hacer por vos es la afiliación: el contrato con el banco lo firma tu empresa, y la comisión por transacción la negociás vos directamente. Te acompañamos en el trámite y les damos a los ejecutivos los datos técnicos que suelen pedir.</p>
<p>Un consejo por experiencia: no arranques con tarjeta si todavía no tenés volumen de pedidos. Empezá con transferencia y contra entrega, medí cuántos pedidos reales entran al mes y activá la tarjeta cuando el número justifique la afiliación. Muchos negocios pagan por una pasarela que procesa tres pagos al mes.</p>
HTML,
        ],
        [
            'block_type' => 'features',
            'eyebrow'    => 'Antes de arrancar',
            'heading'    => 'Lo que necesitás tener listo',
            'body' => '<p>Mientras más completo llegue esto, más rápido sale la tienda.</p>',
            'extra' => [
                'items' => [
                    ['icon' => 'box', 'title' => 'Listado de productos', 'text' => 'En una hoja de cálculo: nombre, descripción corta, precio, categoría y variantes. No hace falta que esté perfecto, pero sí completo.'],
                    ['icon' => 'image', 'title' => 'Fotos de producto', 'text' => 'Una foto por producto como mínimo, sobre fondo claro y parejo. Con un celular reciente y luz de día alcanza.'],
                    ['icon' => 'truck', 'title' => 'Reglas de envío', 'text' => 'Cuánto cobrás a la capital, cuánto al interior, si hacés envío gratis desde cierto monto y con qué empresa despachás.'],
                    ['icon' => 'file', 'title' => 'Datos fiscales', 'text' => 'Cómo facturás los pedidos. Si emitís factura electrónica, definimos desde el inicio cómo se conecta con el flujo de pedidos.'],
                ],
            ],
        ],
        [
            'block_type' => 'pricing_service',
            'eyebrow'    => 'Inversión',
            'heading'    => 'Precio de la tienda virtual',
            'subheading' => 'Precio anual con dominio, alojamiento, SSL y soporte incluidos.',
        ],
        [
            'block_type' => 'related_links',
            'heading'    => 'Seguí leyendo',
            'extra' => [
                'links' => [
                    ['url' => '/blog/como-crear-tienda-en-linea-guatemala/', 'title' => 'Cómo crear una tienda en línea en Guatemala', 'text' => 'Guía paso a paso, desde el dominio hasta el primer pedido.'],
                    ['url' => '/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/', 'title' => 'Cómo cobrar con tarjeta en tu sitio', 'text' => 'Pasarelas disponibles, comisiones y qué pide el banco.'],
                    ['url' => '/blog/woocommerce-vs-shopify-guatemala/', 'title' => 'WooCommerce o Shopify', 'text' => 'Comparación con números reales para un negocio guatemalteco.'],
                    ['url' => '/precios/', 'title' => 'Precios', 'text' => 'Comparativa de los tres servicios en una sola tabla.'],
                ],
            ],
        ],
        [
            'block_type' => 'faq',
            'eyebrow'    => 'Preguntas',
            'heading'    => 'Dudas sobre tiendas en línea',
        ],
        [
            'block_type' => 'cta',
            'heading'    => 'Contanos qué vendés y te decimos qué necesitás',
            'subheading' => 'Revisamos tu catálogo y te damos una propuesta concreta, con precio y tiempo de entrega.',
            'cta_text'   => 'Escribir por WhatsApp',
            'cta_url'    => 'whatsapp',
            'extra'      => ['cta2_text' => 'Llenar formulario', 'cta2_url' => '/contacto/'],
        ],
    ],
];
