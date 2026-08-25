<?php
/**
 * Configuración global inicial. Todo esto es editable desde /admin → Configuración.
 * NAP (nombre, teléfono, correo) idéntico al de Servicom: paginasweb.gt es una marca
 * comercial de la misma empresa, no una empresa distinta.
 */
return [
    // Identidad
    'site_name'        => 'paginasweb.gt',
    'site_tagline'     => 'Páginas web y tiendas virtuales para negocios de Guatemala',
    'legal_name'       => 'Servicom',
    'parent_site_url'  => 'https://servicom.gt',
    'founding_year'    => '2007',
    'years_experience' => '18',

    // Contacto (NAP)
    'phone'          => '3204-0756',
    'phone_display'  => '+502 3204-0756',
    'phone_e164'     => '+50232040756',
    'whatsapp'       => '+50232040756',
    'whatsapp_message' => 'Hola, vi paginasweb.gt y quiero cotizar mi página web.',
    'email'          => 'info@servicom.gt',
    'city'           => 'Ciudad de Guatemala',
    'region'         => 'Guatemala',
    'country'        => 'GT',
    'opening_hours'  => 'Lunes a viernes, 8:00 a 17:00 (hora de Guatemala)',
    // Dejar en blanco si no querés declarar horario en el schema.
    'opening_hours_spec' => '[{"@type":"OpeningHoursSpecification","dayOfWeek":["Monday","Tuesday","Wednesday","Thursday","Friday"],"opens":"08:00","closes":"17:00"}]',
    'price_range'    => 'Q1,250 - Q3,600',

    // Redes (dejar vacío lo que no exista; no inventamos perfiles)
    'social_facebook'  => '',
    'social_instagram' => '',
    'social_linkedin'  => '',
    'social_youtube'   => '',

    // Marca visual
    'color_ink'       => '#0A0C0F',
    'color_paper'     => '#F3F0E9',
    'color_brand'     => '#11E39A',
    'color_brand_ink' => '#04684E',
    'logo'            => '/assets/img/marca.svg',
    'logo_white'      => '/assets/img/marca-blanca.svg',

    // Analítica (se pegan los códigos desde el panel; vacío = no se imprime nada)
    'ga4_id'                => '',
    'search_console_verify' => '',
    'meta_pixel_id'         => '',

    // Textos del pie
    'footer_about' => 'paginasweb.gt es la marca con la que Servicom diseña sitios web y tiendas en línea para negocios guatemaltecos. Mismo equipo, mismo teléfono, mismo compromiso desde 2007.',
    'footer_legal' => 'paginasweb.gt — marca de Servicom, Guatemala.',

    // Formularios
    'form_notify_email' => 'info@servicom.gt',
    'form_thanks'       => 'Gracias por escribirnos. Te respondemos en horario de oficina, normalmente el mismo día.',

    // Bloqueo de indexación mientras el sitio está en pruebas (0 = indexable)
    'site_noindex' => '0',
];
