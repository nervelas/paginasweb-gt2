<?php
/**
 * Configuración de paginasweb.gt
 * Copiá este archivo como config.php y ajustá los valores.
 * El instalador (/install.php) puede generarlo por vos.
 */
return [
    // 'mysql' para hosting cPanel, 'sqlite' para pruebas locales.
    'db' => [
        'driver'   => 'mysql',
        'host'     => 'localhost',
        'port'     => 3306,
        'database' => 'paginasweb',
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8mb4',
        // Ruta del archivo SQLite (solo si driver = sqlite)
        'sqlite_path' => __DIR__ . '/../storage/paginasweb.sqlite',
    ],

    // URL pública sin barra final. Ej: https://paginasweb.gt
    'base_url' => 'https://paginasweb.gt',

    // Ambiente: production | development
    'env' => 'production',

    // Mostrar errores en pantalla (solo en development)
    'debug' => false,

    // Clave para firmar cookies/sesión. Cambiala por una cadena larga y aleatoria.
    'app_key' => 'cambiar-esta-clave-por-una-larga-y-aleatoria',

    // Envío de correo: 'mail' (función mail de PHP) o 'smtp'
    'mail' => [
        'driver'     => 'mail',
        'from_email' => 'info@paginasweb.gt',
        'from_name'  => 'paginasweb.gt',
        'smtp_host'  => '',
        'smtp_port'  => 587,
        'smtp_user'  => '',
        'smtp_pass'  => '',
        'smtp_secure'=> 'tls', // tls | ssl | ''
    ],
];
