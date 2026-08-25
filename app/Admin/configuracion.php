<?php
/**
 * Campos de la pantalla de Configuración, agrupados por tema.
 * Tipos: texto, area, casilla, color, seleccion.
 */
return [
    'identidad' => [
        'titulo' => 'Identidad del sitio',
        'campos' => [
            'site_name'        => ['tipo' => 'texto', 'etiqueta' => 'Nombre del sitio'],
            'site_tagline'     => ['tipo' => 'texto', 'etiqueta' => 'Frase descriptiva'],
            'legal_name'       => ['tipo' => 'texto', 'etiqueta' => 'Nombre de la empresa', 'ayuda' => 'El nombre legal con el que se factura.'],
            'parent_site_url'  => ['tipo' => 'texto', 'etiqueta' => 'Sitio de la empresa madre', 'ayuda' => 'Se enlaza una sola vez desde el pie de página y desde Nosotros.'],
            'founding_year'    => ['tipo' => 'texto', 'etiqueta' => 'Año de fundación'],
            'years_experience' => ['tipo' => 'texto', 'etiqueta' => 'Años de experiencia'],
            'logo'             => ['tipo' => 'texto', 'etiqueta' => 'Logotipo (fondo claro)'],
            'logo_white'       => ['tipo' => 'texto', 'etiqueta' => 'Logotipo (fondo oscuro)'],
        ],
    ],
    'contacto' => [
        'titulo' => 'Contacto',
        'nota'   => 'Estos datos deben coincidir exactamente con los que aparecen en el sitio de la empresa madre y en el perfil de Google. La coherencia del NAP (nombre, teléfono, dirección) es una de las señales locales más importantes.',
        'campos' => [
            'phone_display'    => ['tipo' => 'texto', 'etiqueta' => 'Teléfono como se muestra'],
            'phone_e164'       => ['tipo' => 'texto', 'etiqueta' => 'Teléfono en formato internacional', 'ayuda' => 'Por ejemplo: +50232040756'],
            'whatsapp'         => ['tipo' => 'texto', 'etiqueta' => 'Número de WhatsApp', 'ayuda' => 'En formato internacional.'],
            'whatsapp_message' => ['tipo' => 'area', 'etiqueta' => 'Mensaje que se escribe solo', 'ayuda' => 'Aparece ya escrito cuando alguien abre el chat.'],
            'email'            => ['tipo' => 'texto', 'etiqueta' => 'Correo público'],
            'form_notify_email'=> ['tipo' => 'texto', 'etiqueta' => 'Correo que recibe los formularios'],
            'city'             => ['tipo' => 'texto', 'etiqueta' => 'Ciudad'],
            'region'           => ['tipo' => 'texto', 'etiqueta' => 'Departamento o región'],
            'opening_hours'    => ['tipo' => 'texto', 'etiqueta' => 'Horario que se muestra'],
            'opening_hours_spec' => ['tipo' => 'area', 'etiqueta' => 'Horario en datos estructurados', 'ayuda' => 'JSON de openingHoursSpecification. Dejalo vacío si preferís no declarar horario en el schema.'],
            'price_range'      => ['tipo' => 'texto', 'etiqueta' => 'Rango de precios', 'ayuda' => 'Por ejemplo: Q1,250 - Q3,600'],
        ],
    ],
    'redes' => [
        'titulo' => 'Redes sociales',
        'nota'   => 'Dejá vacío lo que no exista. No conviene enlazar perfiles vacíos o abandonados.',
        'campos' => [
            'social_facebook'  => ['tipo' => 'texto', 'etiqueta' => 'Facebook'],
            'social_instagram' => ['tipo' => 'texto', 'etiqueta' => 'Instagram'],
            'social_linkedin'  => ['tipo' => 'texto', 'etiqueta' => 'LinkedIn'],
            'social_youtube'   => ['tipo' => 'texto', 'etiqueta' => 'YouTube'],
        ],
    ],
    'marca' => [
        'titulo' => 'Colores de la marca',
        'nota'   => 'El sitio alterna dos lienzos (uno oscuro y uno claro) y usa un solo color de señal. Si cambiás los colores, revisá el contraste: el texto debe cumplir al menos 4.5:1 sobre su fondo.',
        'campos' => [
            'color_ink'       => ['tipo' => 'color', 'etiqueta' => 'Lienzo oscuro', 'ayuda' => 'Fondo de la cabecera, el hero y el pie.'],
            'color_paper'     => ['tipo' => 'color', 'etiqueta' => 'Lienzo claro', 'ayuda' => 'Fondo de las secciones de contenido.'],
            'color_brand'     => ['tipo' => 'color', 'etiqueta' => 'Color de señal', 'ayuda' => 'Se usa sobre el lienzo oscuro: botones, acentos y marcas.'],
            'color_brand_ink' => ['tipo' => 'color', 'etiqueta' => 'Señal sobre fondo claro', 'ayuda' => 'Versión oscura del color de señal, para que se lea sobre el lienzo claro.'],
        ],
    ],
    'analitica' => [
        'titulo' => 'Analítica y verificación',
        'nota'   => 'Si dejás un campo vacío, no se imprime ningún código en el sitio.',
        'campos' => [
            'ga4_id'                => ['tipo' => 'texto', 'etiqueta' => 'ID de Google Analytics 4', 'ayuda' => 'Empieza con G-'],
            'search_console_verify' => ['tipo' => 'texto', 'etiqueta' => 'Verificación de Search Console', 'ayuda' => 'Solo el valor del content, sin la etiqueta completa.'],
            'meta_pixel_id'         => ['tipo' => 'texto', 'etiqueta' => 'ID del píxel de Meta'],
        ],
    ],
    'pie' => [
        'titulo' => 'Pie de página',
        'nota'   => 'No pongas listas de municipios ni de palabras clave en el pie. Google lo interpreta como spam.',
        'campos' => [
            'footer_about' => ['tipo' => 'area', 'etiqueta' => 'Texto del pie'],
            'footer_legal' => ['tipo' => 'texto', 'etiqueta' => 'Línea de derechos'],
            'form_thanks'  => ['tipo' => 'area', 'etiqueta' => 'Mensaje al enviar el formulario'],
        ],
    ],
    'buscadores' => [
        'titulo' => 'Buscadores',
        'campos' => [
            'site_noindex' => ['tipo' => 'casilla', 'etiqueta' => 'Bloquear el sitio para los buscadores', 'ayuda' => 'Activalo solo mientras el sitio está en pruebas. Si queda activo, el sitio no aparece en Google.'],
        ],
    ],
];
