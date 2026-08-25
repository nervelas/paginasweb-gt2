<?php
/**
 * Definición de los módulos administrables.
 * Cada recurso describe su tabla, sus campos y cómo se listan y editan.
 *
 * Tipos de campo: texto, area, html, numero, precio, seleccion, casilla,
 *                 imagen, lista, fecha, slug, color, oculto.
 */
return [

    'paginas' => [
        'titulo'    => 'Páginas',
        'singular'  => 'página',
        'tabla'     => 'pages',
        'orden'     => 'sort_order, id',
        'crear'     => false,
        'borrar'    => false,
        'columnas'  => ['name' => 'Página', 'slug' => 'Dirección', 'meta_title' => 'Título SEO', 'visible' => 'Visible'],
        'secciones' => true,
        'campos' => [
            'name'             => ['tipo' => 'texto', 'etiqueta' => 'Nombre interno', 'requerido' => true],
            'slug'             => ['tipo' => 'slug', 'etiqueta' => 'Dirección (slug)', 'ayuda' => 'Se muestra como /slug/. Dejalo vacío solo para la página de inicio. Si lo cambiás, creá una redirección 301 desde la dirección anterior.'],
            'h1'               => ['tipo' => 'texto', 'etiqueta' => 'Título principal (H1)', 'requerido' => true],
            'intro'            => ['tipo' => 'area', 'etiqueta' => 'Resumen interno', 'ayuda' => 'Nota para tu equipo. No se publica.'],
            'meta_title'       => ['tipo' => 'texto', 'etiqueta' => 'Título para Google', 'requerido' => true, 'max' => 60, 'contador' => 60, 'ayuda' => 'Hasta 60 caracteres, con la palabra clave al inicio.'],
            'meta_description' => ['tipo' => 'area', 'etiqueta' => 'Descripción para Google', 'requerido' => true, 'max' => 155, 'contador' => 155, 'filas' => 3],
            'canonical'        => ['tipo' => 'texto', 'etiqueta' => 'URL canónica', 'ayuda' => 'Dejalo vacío salvo que sepás exactamente por qué lo cambiás.'],
            'og_image'         => ['tipo' => 'imagen', 'etiqueta' => 'Imagen para redes sociales', 'ayuda' => 'Ideal 1200 × 630 píxeles.'],
            'robots_index'     => ['tipo' => 'casilla', 'etiqueta' => 'Permitir que Google la indexe', 'defecto' => 1],
            'template'         => ['tipo' => 'oculto'],
            'sort_order'       => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'          => ['tipo' => 'casilla', 'etiqueta' => 'Publicada', 'defecto' => 1],
        ],
    ],

    'servicios' => [
        'titulo'   => 'Servicios',
        'singular' => 'servicio',
        'tabla'    => 'services',
        'orden'    => 'sort_order, id',
        'columnas' => ['name' => 'Servicio', 'page_slug' => 'Página', 'sort_order' => 'Orden', 'visible' => 'Visible'],
        'campos' => [
            'name'       => ['tipo' => 'texto', 'etiqueta' => 'Nombre', 'requerido' => true],
            'short_name' => ['tipo' => 'texto', 'etiqueta' => 'Nombre corto', 'requerido' => true, 'ayuda' => 'El que aparece en la tabla de precios.'],
            'slug'       => ['tipo' => 'slug', 'etiqueta' => 'Identificador', 'requerido' => true],
            'tagline'    => ['tipo' => 'area', 'etiqueta' => 'Frase resumen', 'filas' => 2],
            'summary'    => ['tipo' => 'area', 'etiqueta' => 'Descripción', 'filas' => 4],
            'icon'       => ['tipo' => 'seleccion', 'etiqueta' => 'Icono', 'opciones' => [
                'browser' => 'Navegador', 'cart' => 'Carrito', 'mail' => 'Correo', 'phone' => 'Celular',
                'bolt' => 'Rayo', 'shield' => 'Escudo', 'search' => 'Lupa', 'chat' => 'Mensaje',
                'edit' => 'Lápiz', 'image' => 'Imagen', 'layout' => 'Estructura', 'chart' => 'Gráfica',
                'truck' => 'Camión', 'card' => 'Tarjeta', 'box' => 'Caja', 'file' => 'Documento',
            ]],
            'page_slug'  => ['tipo' => 'texto', 'etiqueta' => 'Página del servicio', 'ayuda' => 'El slug de la página que detalla este servicio.'],
            'sort_order' => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'    => ['tipo' => 'casilla', 'etiqueta' => 'Visible', 'defecto' => 1],
        ],
    ],

    'planes' => [
        'titulo'   => 'Planes y precios',
        'singular' => 'plan',
        'tabla'    => 'plans',
        'orden'    => 'service_id, sort_order, id',
        'columnas' => ['name' => 'Plan', 'price' => 'Precio', 'period' => 'Período', 'featured' => 'Destacado', 'visible' => 'Visible'],
        'campos' => [
            'service_id'      => ['tipo' => 'seleccion', 'etiqueta' => 'Servicio', 'origen' => ['tabla' => 'services', 'valor' => 'id', 'texto' => 'name']],
            'name'            => ['tipo' => 'texto', 'etiqueta' => 'Nombre del plan', 'requerido' => true],
            'badge'           => ['tipo' => 'texto', 'etiqueta' => 'Etiqueta', 'ayuda' => 'Por ejemplo: El más pedido. Dejalo vacío si no aplica.'],
            'price'           => ['tipo' => 'precio', 'etiqueta' => 'Precio (Q)', 'ayuda' => 'Dejalo vacío si el precio es a consultar.'],
            'price_text'      => ['tipo' => 'texto', 'etiqueta' => 'Texto del precio', 'ayuda' => 'Se usa solo si el campo anterior está vacío. Por ejemplo: Consultar.'],
            'price_strike'    => ['tipo' => 'precio', 'etiqueta' => 'Precio tachado (Q)', 'ayuda' => 'Solo si el precio normal es realmente mayor. No inventes descuentos.'],
            'period'          => ['tipo' => 'texto', 'etiqueta' => 'Período', 'ayuda' => 'Por ejemplo: al año.'],
            'price_note'      => ['tipo' => 'area', 'etiqueta' => 'Nota del precio', 'filas' => 2],
            'initial_payment' => ['tipo' => 'precio', 'etiqueta' => 'Pago inicial (Q)'],
            'balance_payment' => ['tipo' => 'precio', 'etiqueta' => 'Saldo (Q)'],
            'features'        => ['tipo' => 'lista', 'etiqueta' => 'Qué incluye', 'ayuda' => 'Una característica por línea.'],
            'cta_text'        => ['tipo' => 'texto', 'etiqueta' => 'Texto del botón'],
            'cta_url'         => ['tipo' => 'texto', 'etiqueta' => 'Enlace del botón', 'ayuda' => 'Escribí whatsapp para que abra el chat con el mensaje configurado.'],
            'featured'        => ['tipo' => 'casilla', 'etiqueta' => 'Destacar este plan'],
            'sort_order'      => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'         => ['tipo' => 'casilla', 'etiqueta' => 'Visible', 'defecto' => 1],
        ],
    ],

    'portafolio' => [
        'titulo'   => 'Portafolio',
        'singular' => 'proyecto',
        'tabla'    => 'portfolio',
        'orden'    => 'sort_order, id',
        'columnas' => ['name' => 'Proyecto', 'domain' => 'Dominio', 'sector' => 'Sector', 'visible' => 'Visible'],
        'campos' => [
            'name'        => ['tipo' => 'texto', 'etiqueta' => 'Nombre del cliente', 'requerido' => true],
            'domain'      => ['tipo' => 'texto', 'etiqueta' => 'Dominio', 'requerido' => true, 'ayuda' => 'Sin https://. Por ejemplo: micliente.com'],
            'url'         => ['tipo' => 'texto', 'etiqueta' => 'Enlace completo', 'requerido' => true],
            'sector'      => ['tipo' => 'texto', 'etiqueta' => 'Sector'],
            'description' => ['tipo' => 'area', 'etiqueta' => 'Qué se hizo', 'filas' => 3],
            'image'       => ['tipo' => 'imagen', 'etiqueta' => 'Imagen del proyecto'],
            'image_alt'   => ['tipo' => 'texto', 'etiqueta' => 'Texto alternativo de la imagen', 'requerido' => true],
            'sort_order'  => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'     => ['tipo' => 'casilla', 'etiqueta' => 'Visible', 'defecto' => 1],
        ],
    ],

    'blog' => [
        'titulo'   => 'Blog',
        'singular' => 'artículo',
        'tabla'    => 'posts',
        'orden'    => 'published_at DESC, id DESC',
        'columnas' => ['title' => 'Artículo', 'published_at' => 'Publicado', 'visible' => 'Visible'],
        'campos' => [
            'title'            => ['tipo' => 'texto', 'etiqueta' => 'Título', 'requerido' => true],
            'slug'             => ['tipo' => 'slug', 'etiqueta' => 'Dirección (slug)', 'requerido' => true, 'desde' => 'title'],
            'category_id'      => ['tipo' => 'seleccion', 'etiqueta' => 'Categoría', 'origen' => ['tabla' => 'categories', 'valor' => 'id', 'texto' => 'name']],
            'excerpt'          => ['tipo' => 'area', 'etiqueta' => 'Resumen', 'filas' => 3, 'max' => 400],
            'body'             => ['tipo' => 'html', 'etiqueta' => 'Contenido', 'filas' => 26],
            'image'            => ['tipo' => 'imagen', 'etiqueta' => 'Imagen destacada'],
            'image_alt'        => ['tipo' => 'texto', 'etiqueta' => 'Texto alternativo de la imagen'],
            'author'           => ['tipo' => 'texto', 'etiqueta' => 'Autor'],
            'published_at'     => ['tipo' => 'fecha', 'etiqueta' => 'Fecha de publicación'],
            'meta_title'       => ['tipo' => 'texto', 'etiqueta' => 'Título para Google', 'max' => 60, 'contador' => 60],
            'meta_description' => ['tipo' => 'area', 'etiqueta' => 'Descripción para Google', 'max' => 155, 'contador' => 155, 'filas' => 3],
            'robots_index'     => ['tipo' => 'casilla', 'etiqueta' => 'Permitir que Google lo indexe', 'defecto' => 1],
            'visible'          => ['tipo' => 'casilla', 'etiqueta' => 'Publicado', 'defecto' => 1],
        ],
    ],

    'categorias' => [
        'titulo'   => 'Categorías del blog',
        'singular' => 'categoría',
        'tabla'    => 'categories',
        'orden'    => 'sort_order, id',
        'columnas' => ['name' => 'Categoría', 'slug' => 'Dirección'],
        'campos' => [
            'name'        => ['tipo' => 'texto', 'etiqueta' => 'Nombre', 'requerido' => true],
            'slug'        => ['tipo' => 'slug', 'etiqueta' => 'Dirección', 'requerido' => true, 'desde' => 'name'],
            'description' => ['tipo' => 'area', 'etiqueta' => 'Descripción', 'filas' => 2],
            'sort_order'  => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
        ],
    ],

    'faq' => [
        'titulo'   => 'Preguntas frecuentes',
        'singular' => 'pregunta',
        'tabla'    => 'faqs',
        'orden'    => 'page_slug, sort_order, id',
        'columnas' => ['question' => 'Pregunta', 'page_slug' => 'Página', 'visible' => 'Visible'],
        'campos' => [
            'page_slug'  => ['tipo' => 'seleccion', 'etiqueta' => 'Página donde aparece', 'origen' => ['tabla' => 'pages', 'valor' => 'slug', 'texto' => 'name'], 'ayuda' => 'Las preguntas de una página generan su bloque de datos estructurados FAQPage.'],
            'question'   => ['tipo' => 'texto', 'etiqueta' => 'Pregunta', 'requerido' => true],
            'answer'     => ['tipo' => 'html', 'etiqueta' => 'Respuesta', 'filas' => 6, 'requerido' => true],
            'sort_order' => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'    => ['tipo' => 'casilla', 'etiqueta' => 'Visible', 'defecto' => 1],
        ],
    ],

    'testimonios' => [
        'titulo'   => 'Testimonios',
        'singular' => 'testimonio',
        'tabla'    => 'testimonials',
        'orden'    => 'sort_order, id',
        'columnas' => ['name' => 'Persona', 'company' => 'Empresa', 'visible' => 'Visible'],
        'aviso'    => 'Publicá únicamente testimonios reales de clientes que estén de acuerdo. Inventar reseñas es una de las causas más comunes de penalización y de problemas legales.',
        'campos' => [
            'name'       => ['tipo' => 'texto', 'etiqueta' => 'Nombre de la persona', 'requerido' => true],
            'role'       => ['tipo' => 'texto', 'etiqueta' => 'Cargo'],
            'company'    => ['tipo' => 'texto', 'etiqueta' => 'Empresa'],
            'quote'      => ['tipo' => 'area', 'etiqueta' => 'Testimonio', 'filas' => 4, 'requerido' => true],
            'source_url' => ['tipo' => 'texto', 'etiqueta' => 'Enlace de origen', 'ayuda' => 'Si viene de Google, Facebook o LinkedIn, pegá el enlace para poder comprobarlo.'],
            'image'      => ['tipo' => 'imagen', 'etiqueta' => 'Foto'],
            'sort_order' => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'    => ['tipo' => 'casilla', 'etiqueta' => 'Visible', 'defecto' => 1],
        ],
    ],

    'menus' => [
        'titulo'   => 'Menús',
        'singular' => 'enlace',
        'tabla'    => 'menu_items',
        'orden'    => 'location, sort_order, id',
        'columnas' => ['label' => 'Texto', 'url' => 'Enlace', 'location' => 'Ubicación', 'visible' => 'Visible'],
        'campos' => [
            'location'   => ['tipo' => 'seleccion', 'etiqueta' => 'Ubicación', 'opciones' => [
                'header'           => 'Menú principal',
                'footer_servicios' => 'Pie: Servicios',
                'footer_empresa'   => 'Pie: Empresa',
                'footer_legal'     => 'Pie: Legal',
            ]],
            'label'      => ['tipo' => 'texto', 'etiqueta' => 'Texto del enlace', 'requerido' => true],
            'url'        => ['tipo' => 'texto', 'etiqueta' => 'Enlace', 'requerido' => true],
            'rel'        => ['tipo' => 'texto', 'etiqueta' => 'Atributo rel', 'ayuda' => 'Normalmente vacío. Solo para casos puntuales.'],
            'sort_order' => ['tipo' => 'numero', 'etiqueta' => 'Orden'],
            'visible'    => ['tipo' => 'casilla', 'etiqueta' => 'Visible', 'defecto' => 1],
        ],
    ],

    'redirecciones' => [
        'titulo'   => 'Redirecciones 301',
        'singular' => 'redirección',
        'tabla'    => 'redirects',
        'orden'    => 'id DESC',
        'columnas' => ['source' => 'Desde', 'destination' => 'Hacia', 'status_code' => 'Código', 'hits' => 'Usos'],
        'campos' => [
            'source'      => ['tipo' => 'texto', 'etiqueta' => 'Dirección anterior', 'requerido' => true, 'ayuda' => 'Empezá con barra. Por ejemplo: /pagina-vieja/'],
            'destination' => ['tipo' => 'texto', 'etiqueta' => 'Dirección nueva', 'requerido' => true],
            'status_code' => ['tipo' => 'seleccion', 'etiqueta' => 'Tipo', 'opciones' => [301 => '301 · Permanente', 302 => '302 · Temporal'], 'defecto' => 301],
        ],
    ],
];
