# Seguridad del sitio

Este documento describe qué protege el sitio, cómo se comprueba y qué tiene que
hacer quien lo administra. No es una lista de buenas intenciones: cada punto se
verifica solo con `php tools/verificar.php` (sección 10) y con
`php tools/probar-panel.php`.

## 1. Entrada al panel

- Las contraseñas se guardan con `password_hash()` (bcrypt). Nunca en texto plano.
- Cinco intentos fallidos bloquean el acceso 15 minutos, por correo y por IP.
- Un correo que no existe tarda lo mismo que uno que sí: no se puede averiguar
  qué usuarios están dados de alta midiendo el tiempo de respuesta.
- Al entrar se cambia el identificador de sesión (`session_regenerate_id`), así
  que una sesión preparada de antemano por un atacante deja de servir.
- La cookie de sesión va marcada `HttpOnly`, `SameSite=Lax` y `Secure` cuando el
  sitio corre sobre HTTPS.
- La sesión caduca por inactividad a las 2 horas.
- El panel se sirve con `X-Robots-Tag: noindex` y `Cache-Control: no-store`: no
  se indexa en Google ni queda guardado en la caché del navegador.

## 2. Formularios

- Todos los formularios, del panel y del sitio público, llevan token CSRF. Un
  envío sin token válido se rechaza con HTTP 419.
- El formulario de contacto tiene además:
  - trampa para robots (campo oculto que un visitante real nunca llena),
  - validación de nombre, correo, teléfono y largo del mensaje,
  - **límite de 5 envíos por hora desde la misma IP**, para frenar el envío
    masivo automatizado.
- Los asuntos de correo se codifican en base64, de modo que nadie puede colar
  encabezados extra en el mensaje.

## 3. Base de datos

- Todas las consultas usan sentencias preparadas con parámetros.
- Los nombres de tabla y de columna, que no se pueden mandar como parámetro,
  pasan por `Database::ident()`; solo se aceptan letras, números y guion bajo.
  Las cláusulas `ORDER BY` pasan por `Database::orden()`.
- El verificador revisa línea por línea que ninguna consulta se arme pegando
  variables sin validar, y falla si aparece una.

## 4. Contenido y texto

- El HTML que se guarda desde el panel pasa por `clean_html()`, que quita:
  `script`, `style`, `iframe`, `object`, `embed`, `form`, `svg`, `base`,
  comentarios, atributos de evento (`onclick`, `onerror`…), `formaction`,
  `srcdoc`, y enlaces con esquema `javascript:`, `vbscript:`, `data:` o `blob:`
  (solo se permite `data:` para imágenes).
- También quita los estilos que esconden texto (`display:none`,
  `visibility:hidden`, `text-indent:-9999px`…). Eso protege dos cosas a la vez:
  la seguridad y la política antispam de Google.
- Todo lo que se imprime en pantalla pasa por `e()` (`htmlspecialchars`).

## 5. Archivos y carpetas

- `public/uploads/` no ejecuta código: se le apaga el intérprete de PHP, se
  quitan los manejadores y se niega el acceso a cualquier archivo `.php`,
  `.phar`, `.cgi`, `.sh` y similares. Aunque alguien lograra subir un archivo
  con código, el servidor no lo correría.
- `config/` y `storage/` están fuera de la carpeta pública y además tienen su
  propio `.htaccess` que niega todo acceso web.
- Las reglas van dentro de bloques `<IfModule>`, así que el sitio no se cae con
  un error 500 en servidores con PHP-FPM, CGI o Apache 2.2.
- No se aceptan listados de carpetas ni los métodos `TRACE`, `TRACK` y `DEBUG`.

## 6. Subida de imágenes

- El tipo se determina leyendo el contenido con `getimagesize()`, nunca por la
  extensión ni por lo que dice el navegador.
- Solo JPG, PNG, WebP y GIF. **No se aceptan SVG**, porque pueden llevar código.
- Máximo 8 MB y 1920 px de ancho; la imagen se vuelve a generar desde cero, lo
  que elimina cualquier carga escondida en los metadatos.
- El nombre del archivo se reescribe con una parte aleatoria.

## 7. Instalador

- `public/install.php` se niega a correr si ya existe `storage/instalado.lock`
  **o** `config/config.php`. Nadie puede reinstalar el sitio y quedarse con el
  usuario administrador borrando un solo archivo.
- Aun así, **borrá `public/install.php` del servidor** después de instalar.

## 8. Errores

- En producción (`'debug' => false`) nunca se muestran rutas de archivos ni
  consultas. El visitante ve una página sobria y el detalle queda en
  `storage/errores.log`, que no es accesible por web.

## 9. Lo que tenés que hacer vos

1. Borrar `public/install.php` apenas termines de instalar.
2. Cambiar la contraseña del administrador en el primer ingreso (el panel te
   obliga).
3. Activar el certificado SSL y, cuando ya funcione bien, descomentar la línea
   `Strict-Transport-Security` en `public/.htaccess`.
4. Mantener copias de seguridad desde cPanel (base de datos y `public/uploads/`).
5. No instalar código de terceros dentro de `public/` sin revisarlo.
