<?php
/**
 * Arma el paquete listo para subir por cPanel.
 * Deja fuera lo que no debe ir al servidor (git, node, base de pruebas,
 * config generado, capturas) y añade un LÉEME con los pasos.
 *
 * Uso: php tools/empaquetar.php [carpeta-destino]
 */
$root    = dirname(__DIR__);
$destino = isset($argv[1]) ? rtrim($argv[1], '/') : $root . '/entrega';
$sello   = date('Y-m-d');
$nombre  = 'paginasweb-gt-' . $sello;
$staging = sys_get_temp_dir() . '/' . $nombre;

@mkdir($destino, 0755, true);
exec('rm -rf ' . escapeshellarg($staging));
@mkdir($staging, 0755, true);

$excluir = [
    '.git', '.gitignore', 'node_modules', 'entrega', 'storage/paginasweb.sqlite',
    'storage/instalado.lock', 'config/config.php', 'vista-previa.html',
];

echo "Copiando archivos...\n";
$rsync = 'cp -a ' . escapeshellarg($root) . '/. ' . escapeshellarg($staging) . '/';
exec($rsync);
foreach ($excluir as $ruta) {
    exec('rm -rf ' . escapeshellarg($staging . '/' . $ruta));
}

// Carpetas que deben existir vacías en el servidor
foreach (['storage', 'public/uploads'] as $carpeta) {
    @mkdir($staging . '/' . $carpeta, 0755, true);
}

// LÉEME en la raíz del paquete, para quien abra el zip sin leer docs/
$leeme = <<<TXT
paginasweb.gt — paquete de instalación ({$sello})
================================================================

QUÉ CONTIENE
  public/     Esta carpeta es la que debe apuntar el dominio (document root).
  app/        Código de la aplicación. Va FUERA de la web.
  config/     Configuración. Va FUERA de la web.
  database/   Esquema y contenido inicial. Va FUERA de la web.
  storage/    Archivos internos. Va FUERA de la web.
  tools/      Utilidades de mantenimiento. Va FUERA de la web.
  docs/       Documentación completa. Empezá por docs/INSTALACION.md.

INSTALACIÓN EN CINCO PASOS
  1. Subí y descomprimí este paquete en tu cuenta de cPanel, por ejemplo en
     /home/TUUSUARIO/paginasweb-gt/
  2. En cPanel → Domains, apuntá el Document Root de paginasweb.gt a
     /home/TUUSUARIO/paginasweb-gt/public
     (Si tu hosting no lo permite, mirá la Opción B de docs/INSTALACION.md)
  3. En cPanel → MySQL Databases, creá una base, un usuario y asignale
     todos los privilegios. Anotá los tres datos.
  4. Abrí https://paginasweb.gt/install.php y completá el formulario.
     El instalador crea las tablas y carga todo el contenido.
  5. BORRÁ el archivo public/install.php del servidor.

REQUISITOS
  PHP 7.4 o superior · MySQL 5.7 / MariaDB 10.3 · Apache con mod_rewrite
  Extensiones: pdo, pdo_mysql, mbstring, json (recomendada: gd con WebP)

DESPUÉS DE INSTALAR
  Entrá a https://paginasweb.gt/admin/ y revisá Configuración:
  teléfono, WhatsApp, correo, horario y códigos de analítica.

  Confirmá el horario de atención antes de dejarlo publicado: el valor
  cargado por defecto es Lunes a viernes de 8:00 a 17:00.

LEÉ ESTO ANTES DE PUBLICAR CONTENIDO
  docs/ANTI-PENALIZACION.md  — qué se hizo y qué no hacer nunca
  docs/POST-LANZAMIENTO.md   — plan de 90 días
  docs/SEO.md                — palabra clave por página y lista de control
TXT;
file_put_contents($staging . '/LEEME.txt', $leeme);

echo "Comprimiendo...\n";
$zip = $destino . '/' . $nombre . '.zip';
@unlink($zip);
exec('cd ' . escapeshellarg(dirname($staging)) . ' && zip -rq ' . escapeshellarg($zip) . ' ' . escapeshellarg($nombre));
exec('rm -rf ' . escapeshellarg($staging));

$archivos = (int) trim(shell_exec('unzip -l ' . escapeshellarg($zip) . ' | tail -1 | awk \'{print $2}\''));
printf("\nPaquete: %s\n", $zip);
printf("Peso: %s KB · %d archivos\n", number_format(filesize($zip) / 1024), $archivos);
