# Instalación en hosting compartido con cPanel

Tiempo estimado: 30 a 45 minutos, incluyendo la propagación del dominio.

---

## 1. Requisitos del servidor

| Requisito | Mínimo | Recomendado |
|---|---|---|
| PHP | **7.4** | 8.1 o superior |
| Base de datos | MySQL 5.7 / MariaDB 10.3 | MariaDB 10.6+ |
| Extensiones PHP | `pdo`, `pdo_mysql`, `mbstring`, `json` | además `gd` con WebP, `curl` |
| Servidor web | Apache con `mod_rewrite` | además `mod_headers`, `mod_deflate`, `mod_expires` |
| Espacio en disco | 60 MB | 500 MB (para las imágenes que subas) |
| Certificado SSL | Obligatorio | Let's Encrypt de cPanel (gratuito) |

El proyecto **no necesita Node ni Composer en producción**. Los archivos CSS y JS ya
vienen minificados en el repositorio.

### Elegir la versión de PHP en cPanel

1. Entrá a cPanel → **Select PHP Version** (o *MultiPHP Manager*).
2. Elegí **8.1** o superior. Si tu hosting solo ofrece 7.4, también funciona.
3. En la pestaña de extensiones, verificá que estén activas: `pdo_mysql`, `mbstring`,
   `json`, `gd`, `curl`, `fileinfo`, `openssl`.
4. Guardá.

Si `gd` no está disponible, el sitio funciona igual: solo se pierde la conversión
automática a WebP al subir imágenes desde el panel (se guardan en JPG).

---

## 2. Crear la base de datos

1. cPanel → **MySQL Databases**.
2. Creá una base, por ejemplo `usuario_paginasweb`. Anotá el nombre completo, que
   incluye el prefijo de tu cuenta.
3. Creá un usuario con una contraseña larga generada por cPanel. Anotala.
4. Asignale al usuario **todos los privilegios** sobre esa base.

---

## 3. Subir los archivos

### Estructura del proyecto

```
paginasweb-gt/
├── app/            Código de la aplicación (fuera de la web)
├── config/         Configuración (fuera de la web)
├── database/       Esquema y contenido inicial (fuera de la web)
├── docs/           Documentación (fuera de la web)
├── storage/        Archivos internos y bloqueo del instalador
├── tools/          Utilidades de mantenimiento
└── public/         ← ESTA carpeta es el document root
    ├── index.php
    ├── install.php
    ├── .htaccess
    ├── admin/
    ├── assets/
    └── uploads/
```

> **Importante:** el document root del dominio debe apuntar a `public/`, no a la raíz
> del proyecto. Si `app/`, `config/` o `database/` quedan accesibles desde el navegador,
> se expone la configuración de la base de datos.

### Opción A — El dominio permite cambiar el document root (recomendado)

1. Subí **todo el proyecto** por FTP o por el Administrador de archivos a una carpeta
   fuera de `public_html`, por ejemplo `/home/usuario/paginasweb-gt/`.
2. cPanel → **Domains** (o *Addon Domains*) → editá el dominio `paginasweb.gt`.
3. Cambiá el **Document Root** a `/home/usuario/paginasweb-gt/public`.
4. Guardá.

### Opción B — El hosting no permite cambiar el document root

1. Subí el contenido de `public/` **directamente dentro** de `public_html/`.
2. Subí `app/`, `config/`, `database/`, `storage/` y `tools/` **un nivel arriba**, es
   decir en `/home/usuario/`.
3. Editá `public_html/index.php`, `public_html/install.php` y
   `public_html/admin/index.php`, y ajustá la ruta del `require` inicial para que
   apunte a la nueva ubicación de `app/bootstrap.php`. Por ejemplo:

   ```php
   require '/home/usuario/app/bootstrap.php';
   ```

4. Verificá que los archivos `.htaccess` de `config/` y `storage/` se hayan subido: son
   la protección de respaldo si algo queda dentro de la web.

---

## 4. Permisos de carpetas

Desde el Administrador de archivos de cPanel, o por FTP:

| Carpeta | Permisos |
|---|---|
| Carpetas en general | `755` |
| Archivos en general | `644` |
| `config/` | `755` (debe permitir escritura durante la instalación) |
| `storage/` | `755` con escritura |
| `public/uploads/` | `755` con escritura |

Si tu hosting usa `suPHP`, `755` es correcto. Si el instalador se queja de permisos,
subí temporalmente `config/` y `storage/` a `775`, instalá, y volvé a `755`.

---

## 5. Ejecutar el instalador

1. Abrí `https://paginasweb.gt/install.php` en el navegador.
2. **Paso 1: requisitos.** El instalador revisa versión de PHP, extensiones y permisos.
   Todo lo marcado como "Falta" en rojo debe resolverse antes de continuar. Lo marcado
   como "Opcional" no bloquea.
3. **Paso 2: datos.** Completá:
   - Motor: **MySQL / MariaDB**
   - Servidor: `localhost` (así es en casi todos los cPanel)
   - Puerto: `3306`
   - Base de datos, usuario y contraseña: los del paso 2
   - Dirección del sitio: `https://paginasweb.gt` (sin barra al final)
   - Tu nombre, tu correo (será tu usuario del panel) y una contraseña de al menos
     10 caracteres
4. Presioná **Instalar el sitio**.

El instalador crea las tablas, carga las 12 páginas con sus 68 secciones, los 3
servicios con sus 4 planes, los 24 proyectos del portafolio, las 34 preguntas
frecuentes, las 5 categorías y los 6 artículos del blog, y genera `config/config.php`.

5. **Borrá `public/install.php` del servidor.** El instalador se autobloquea al
   terminar (crea `storage/instalado.lock`), pero conviene eliminar el archivo. El
   panel muestra una alerta roja mientras siga presente.

### Alternativa: importar el SQL a mano

Si preferís no usar el instalador (o si tu hosting bloquea la creación de tablas desde
PHP), podés cargar todo desde phpMyAdmin:

1. cPanel → **phpMyAdmin** → seleccioná tu base de datos.
2. Pestaña **Importar** → subí `database/schema.sql` → Continuar.
3. Pestaña **Importar** → subí `database/seed.sql` → Continuar.
4. Copiá `config/config.sample.php` a `config/config.php` y completá los datos de la
   base y la dirección del sitio.
5. Creá tu usuario del panel ejecutando esto en la pestaña **SQL** de phpMyAdmin,
   reemplazando el correo y generando el hash con
   `php -r "echo password_hash('TU-CONTRASEÑA', PASSWORD_DEFAULT);"`:

   ```sql
   INSERT INTO users (name, email, password_hash, role, active, must_change_password, created_at)
   VALUES ('Tu nombre', 'tu@correo.com', 'EL-HASH-GENERADO', 'admin', 1, 0, NOW());
   ```

6. Creá el archivo `storage/instalado.lock` con cualquier contenido y borrá
   `public/install.php`.

---

## 6. Certificado SSL

1. cPanel → **SSL/TLS Status**.
2. Seleccioná `paginasweb.gt` y `www.paginasweb.gt`.
3. Presioná **Run AutoSSL** y esperá unos minutos.
4. Abrí `https://paginasweb.gt` y confirmá que aparece el candado.

El `.htaccess` ya fuerza HTTPS y redirige `www` a la versión sin `www`.

Cuando confirmes que el certificado funciona en el dominio y en todos sus subdominios,
podés activar HSTS quitando el comentario de esta línea en `public/.htaccess`:

```apache
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
```

> No la actives antes de tener el SSL funcionando: si algo falla, los navegadores
> recordarán la política durante un año y el sitio quedará inaccesible.

---

## 7. DNS

En el panel de tu registrador de dominios:

| Tipo | Nombre | Valor |
|---|---|---|
| A | `@` | La IP de tu hosting (aparece en cPanel, panel izquierdo) |
| A | `www` | La misma IP |
| MX | `@` | Según lo que use tu correo (cPanel o Google Workspace) |
| TXT | `@` | Registro SPF de tu proveedor de correo |
| TXT | `default._domainkey` | Registro DKIM que genera cPanel en *Email Deliverability* |

La propagación toma entre 15 minutos y 24 horas. Podés verificarla en
<https://dnschecker.org>.

---

## 8. Después de instalar

1. Entrá a `https://paginasweb.gt/admin/` con el correo y la contraseña que definiste.
2. Revisá **Configuración**:
   - Teléfono, WhatsApp y correo (deben coincidir exactamente con los de servicom.gt)
   - Horario de atención — **confirmá que sea el real** antes de dejarlo publicado
   - Redes sociales (dejá vacío lo que no exista)
   - Códigos de Google Analytics 4 y de verificación de Search Console
3. Andá a **Herramientas** y enviá un correo de prueba para confirmar que los
   formularios llegan.
4. Revisá el sitio en tu celular.
5. Ejecutá la verificación desde una computadora con PHP:

   ```bash
   php tools/verificar.php https://paginasweb.gt
   ```

6. Seguí el plan de [POST-LANZAMIENTO.md](POST-LANZAMIENTO.md).

---

## 9. Copias de seguridad

**Antes de cualquier cambio importante:**

- Base de datos: cPanel → **phpMyAdmin** → seleccionar la base → *Exportar* → *Rápido* → SQL.
- Archivos: cPanel → **Backup** → *Descargar una copia del directorio principal*.

Programá una copia mensual como mínimo. Muchos hostings de cPanel las hacen
automáticamente, pero conviene confirmarlo y descargar una copia propia de vez en cuando.

---

## 10. Problemas frecuentes

| Síntoma | Causa habitual | Solución |
|---|---|---|
| Error 500 al abrir el sitio | `mod_rewrite` desactivado o `.htaccess` no subido | Verificá que `public/.htaccess` exista; consultá al hosting si `mod_rewrite` está activo |
| "La base de datos no está instalada" | El instalador no terminó | Volvé a ejecutar `install.php`; si dice que ya está instalado, borrá `storage/instalado.lock` |
| Solo funciona la página de inicio | El enrutamiento no llega a `index.php` | Casi siempre es `mod_rewrite`. Revisá también que `AllowOverride All` esté permitido |
| Las imágenes que subo no se ven | Falta permiso de escritura en `public/uploads/` | Poné `755` con escritura en esa carpeta |
| Los formularios no llegan | `mail()` bloqueado por el hosting | En `config/config.php` cambiá `'driver' => 'smtp'` y completá los datos SMTP de tu cuenta de correo |
| El sitio no aparece en Google | La casilla de bloqueo está activa | **/admin → Configuración → Buscadores**, desactivala |
| Se ve sin estilos | Los archivos `.min.css` no se subieron | Verificá `public/assets/css/`; si editaste los fuentes, ejecutá `php tools/build-assets.php` |
| Error de conexión a la base | Nombre de base o usuario sin el prefijo de cPanel | Usá el nombre completo, con prefijo (`usuario_paginasweb`) |

---

## 11. Actualizar el sitio más adelante

El contenido se edita desde el panel; no hace falta tocar archivos.

Si alguna vez actualizás el código:

1. Hacé copia de la base y de los archivos.
2. Reemplazá `app/`, `public/assets/`, `public/index.php` y `public/admin/`.
3. **No toques** `config/config.php` ni `public/uploads/`.
4. Ejecutá `php tools/verificar.php https://paginasweb.gt`.
