<?php
return [
    'slug'     => '',
    'name'     => 'Inicio',
    'template' => 'home',
    'h1'       => 'Páginas Web en Guatemala',
    'meta_title'       => 'Páginas Web en Guatemala | Diseño desde Q1,250',
    'meta_description' => 'Diseñamos páginas web y tiendas virtuales para negocios de Guatemala. Dominio, hosting y soporte incluidos desde Q1,250 al año. Empezá con Q250.',
    'og_image' => '/assets/img/og/og-inicio.webp',
    'sort_order' => 1,
    'sections' => [
        [
            'block_type' => 'hero',
            'eyebrow'    => 'Una marca de Servicom · desde 2007',
            'heading'    => 'Páginas Web en Guatemala',
            'subheading' => 'Diseñamos el sitio que tu negocio necesita para dejar de explicar lo mismo por mensaje: qué vendés, por qué valés lo que cobrás y cómo te contactan. Con dominio, alojamiento y soporte incluidos, desde Q1,250 al año.',
            'cta_text'   => 'Cotizar por WhatsApp',
            'cta_url'    => 'whatsapp',
            'image'      => '/assets/img/hero-sitio-en-celular-y-laptop.webp',
            'image_alt'  => 'Sitio web guatemalteco mostrado en una laptop y en un celular',
            'extra'      => [
                'accent'    => 'que sí traen clientes',
                'cta2_text' => 'Ver precios',
                'cta2_url'  => '/precios/',
                'notes'     => ['Respuesta el mismo día hábil', 'Trabajamos 100% en línea', 'Precios en quetzales, sin sorpresas'],
            ],
        ],
        [
            'block_type' => 'stats',
            'heading'    => null,
            'extra'      => [
                'items' => [
                    ['value' => '18', 'label' => 'años diseñando sitios en Guatemala'],
                    ['value' => '24', 'label' => 'sitios publicados que podés visitar hoy'],
                    ['value' => 'Q250', 'label' => 'para arrancar tu proyecto'],
                    ['value' => '100%', 'label' => 'del trabajo en línea, sin visitas presenciales'],
                ],
            ],
        ],
        [
            'block_type' => 'rich_text',
            'eyebrow'    => 'Por qué existe este sitio',
            'heading'    => 'Un sitio web sirve cuando le quita trabajo a tu negocio',
            'body' => <<<'HTML'
<p>La mayoría de negocios guatemaltecos ya tiene página de Facebook, catálogo en WhatsApp y quizá un perfil en Instagram. Y aun así pierden clientes todos los días por lo mismo: alguien pregunta el precio a las nueve de la noche, nadie contesta hasta el día siguiente, y para entonces ya compró en otro lado. O el cliente pide "algo formal para presentarlo a la empresa" y lo único que hay para mandar es una foto de un catálogo.</p>
<p>Una página web bien hecha resuelve eso sin que vos tengás que estar pegado al celular. Contesta las preguntas de siempre, muestra tu trabajo con orden, deja claro cuánto cuesta o por qué hay que cotizar, y te llega el contacto ya con la información que necesitás para responder. No reemplaza a tu vendedor: le quita de encima las cinco preguntas que repite todo el día.</p>
<p>Nosotros llevamos desde 2007 haciendo exactamente eso para empresas de Guatemala: bufetes, talleres, distribuidoras, clínicas, importadoras y negocios de servicio a domicilio. Aprendimos que lo que funciona aquí no es el sitio más elaborado, sino el que carga rápido con datos móviles, se entiende en una pantalla de seis pulgadas y tiene el botón de WhatsApp donde la persona lo va a buscar.</p>
HTML,
        ],
        [
            'block_type' => 'services_grid',
            'eyebrow'    => 'Qué hacemos',
            'heading'    => 'Tres servicios, sin paquetes confusos',
            'subheading' => 'No vendemos veinte planes con nombres de metales. Hacemos tres cosas y las hacemos completas.',
        ],
        [
            'block_type' => 'features',
            'eyebrow'    => 'Cómo trabajamos',
            'heading'    => 'Lo que incluye cualquier proyecto, sin costo extra',
            'body' => <<<'HTML'
<p>Estas cosas no son "el plan premium". Van incluidas porque un sitio sin ellas no sirve, y cobrarlas aparte sería vender a medias.</p>
HTML,
            'extra' => [
                'items' => [
                    ['icon' => 'phone', 'title' => 'Diseño pensado desde el celular', 'text' => 'Más de siete de cada diez visitas en Guatemala llegan desde un teléfono. Empezamos el diseño ahí y después lo ampliamos a computadora, no al revés.'],
                    ['icon' => 'bolt', 'title' => 'Carga rápida con datos móviles', 'text' => 'Optimizamos imágenes y código para que el sitio abra aunque la señal esté floja. Un segundo de más es un cliente menos.'],
                    ['icon' => 'shield', 'title' => 'Certificado SSL y respaldos', 'text' => 'Tu sitio abre con candado en el navegador desde el primer día, y guardamos respaldos periódicos del alojamiento.'],
                    ['icon' => 'search', 'title' => 'Bases de SEO bien puestas', 'text' => 'Títulos, descripciones, direcciones limpias, mapa del sitio y datos estructurados. Sin promesas de "primer lugar en una semana".'],
                    ['icon' => 'chat', 'title' => 'WhatsApp integrado de verdad', 'text' => 'Botón flotante con mensaje prellenado, para que el cliente escriba sin tener que explicar de dónde salió.'],
                    ['icon' => 'edit', 'title' => 'Vos podés editar tu contenido', 'text' => 'Te dejamos un panel en español para cambiar textos, precios, fotos y publicaciones sin depender de nosotros.'],
                ],
            ],
        ],
        [
            'block_type' => 'process',
            'eyebrow'    => 'El proceso',
            'heading'    => 'De la primera llamada al sitio publicado',
            'subheading' => 'Cinco pasos, sin reuniones eternas. Todo se puede hacer por WhatsApp, correo y videollamada.',
            'extra' => [
                'steps' => [
                    ['title' => 'Conversamos qué necesita tu negocio', 'text' => 'Una llamada o un chat de veinte minutos: a qué te dedicás, quién te compra, qué te preguntan siempre y qué querés lograr con el sitio.'],
                    ['title' => 'Definimos estructura y presupuesto', 'text' => 'Te decimos qué secciones tiene sentido incluir y cuánto cuesta. Si el proyecto no amerita el gasto, te lo decimos.'],
                    ['title' => 'Diseñamos y armamos el contenido', 'text' => 'Con Q250 arrancamos. Nosotros redactamos y ordenamos la información; vos nos pasás fotos, logo y los datos que solo vos sabés.'],
                    ['title' => 'Revisás y pedís cambios', 'text' => 'Te mostramos el sitio funcionando en una dirección de prueba. Ajustamos textos, colores y orden de las secciones hasta que estés conforme.'],
                    ['title' => 'Publicamos y te enseñamos a usarlo', 'text' => 'Configuramos dominio, SSL, correos y analítica. Te damos acceso al panel y una capacitación por videollamada.'],
                ],
            ],
        ],
        [
            'block_type' => 'portfolio_grid',
            'eyebrow'    => 'Portafolio',
            'heading'    => 'Sitios que están en línea ahora mismo',
            'subheading' => 'No son maquetas de presentación: son sitios de clientes reales que podés abrir y revisar.',
            'cta_text'   => 'Ver todo el portafolio',
            'cta_url'    => '/portafolio/',
            'extra'      => ['limit' => 8],
        ],
        [
            'block_type' => 'pricing_summary',
            'eyebrow'    => 'Precios',
            'heading'    => 'Cuánto cuesta, en quetzales y sin letra chiquita',
            'subheading' => 'Precio anual que incluye dominio, alojamiento y soporte. Empezás con un pago inicial y el saldo se paga cuando aprobás el diseño.',
            'cta_text'   => 'Ver el detalle de precios',
            'cta_url'    => '/precios/',
        ],
        [
            'block_type' => 'comparison',
            'eyebrow'    => 'Para que decidas con criterio',
            'heading'    => 'Cómo trabajamos y cómo no',
            'subheading' => 'No hablamos de otras agencias. Solo dejamos claro qué esperar de nosotros para que compares con lo que te ofrezcan.',
            'extra' => [
                'yes_title' => 'Lo que sí hacemos',
                'no_title'  => 'Lo que no vas a encontrar acá',
                'yes' => [
                    'Precio cerrado en quetzales antes de empezar',
                    'Dominio a nombre de tu empresa, no del nuestro',
                    'Panel propio para que edités sin pedirnos permiso',
                    'Textos redactados por nosotros con la información que nos das',
                    'Soporte con una persona que conoce tu proyecto',
                    'Entrega de accesos completos cuando los pedís',
                ],
                'no' => [
                    'Promesas de aparecer primero en Google en una semana',
                    'Plantillas compradas que ya usaron otros diez negocios',
                    'Cobros sorpresa por cambiar un texto o una foto',
                    'Contratos que te amarran el dominio',
                    'Sitios pesados llenos de animaciones que nadie ve',
                    'Reseñas o cifras inventadas para verse más grandes',
                ],
            ],
        ],
        [
            'block_type' => 'testimonials',
            'eyebrow'    => 'Clientes',
            'heading'    => 'Lo que dicen quienes ya trabajaron con nosotros',
            'subheading' => 'Publicamos únicamente testimonios verificables de clientes reales.',
        ],
        [
            'block_type' => 'posts_grid',
            'eyebrow'    => 'Blog',
            'heading'    => 'Guías para decidir sin depender de un vendedor',
            'subheading' => 'Escribimos sobre precios, pasarelas de pago, dominios .gt y errores comunes al contratar.',
            'cta_text'   => 'Ver todas las guías',
            'cta_url'    => '/blog/',
            'extra'      => ['limit' => 3],
        ],
        [
            'block_type' => 'faq',
            'eyebrow'    => 'Dudas frecuentes',
            'heading'    => 'Lo que nos preguntan antes de contratar',
        ],
        [
            'block_type' => 'cta',
            'heading'    => 'Contanos qué necesita tu negocio',
            'subheading' => 'Escribinos por WhatsApp o dejanos tus datos. Te respondemos con una propuesta concreta: qué secciones, cuánto cuesta y en cuánto tiempo.',
            'cta_text'   => 'Escribir por WhatsApp',
            'cta_url'    => 'whatsapp',
            'extra'      => ['cta2_text' => 'Llenar formulario', 'cta2_url' => '/contacto/'],
        ],
    ],
];
