# paginasweb.gt

Sitio web administrable de **paginasweb.gt**, la marca con la que **Servicom** diseña
páginas web y tiendas virtuales para negocios de Guatemala.

Hecho en PHP sin framework, pensado para hosting compartido con cPanel. Sin Node ni
Composer en producción.

---

## Qué incluye

- **12 páginas** con contenido original en español de Guatemala.
- **6 artículos** de blog de más de 1,200 palabras cada uno, con datos reales del país.
- **34 preguntas frecuentes** asignables por página, que generan el schema `FAQPage`.
- **24 proyectos** de portafolio con enlace a los sitios en línea.
- **Panel de administración** en español, usable desde el celular, con 15 módulos.
- **Sistema visual propio** "Taller editorial": lienzo alterno obsidiana/hueso, un solo
  color de señal, reglas capilares y tipografía editorial.
- **Imágenes originales**: logotipo en trazos, láminas técnicas SVG, composición del
  hero y portadas para redes.
- **SEO técnico completo**: JSON-LD, sitemap y robots dinámicos, canonical, hreflang,
  Open Graph, redirecciones 301 administrables.

## Estado de las verificaciones

| Verificación | Resultado |
|---|---|
| `php tools/verificar.php` | 0 fallas, 0 avisos |
| `php tools/probar-panel.php` | 0 fallas (26 pruebas) |
| `php tools/revisar-enlaces.php` | 0 enlaces rotos, 0 páginas huérfanas (23 páginas) |
| Lighthouse móvil, 8 páginas | 98–100 en rendimiento, accesibilidad, buenas prácticas y SEO |
| Validación HTML (33 documentos) | Sin errores |
| Compatibilidad PHP | 7.4 a 8.4 |

## Requisitos

PHP **7.4 o superior**, MySQL 5.7 / MariaDB 10.3, Apache con `mod_rewrite`.
Extensiones: `pdo`, `pdo_mysql`, `mbstring`, `json`. Recomendada: `gd` con soporte WebP.

## Instalación rápida

1. Subí el proyecto al servidor y apuntá el document root a `public/`.
2. Creá una base de datos MySQL en cPanel.
3. Abrí `https://tudominio/install.php` y seguí los tres pasos.
4. Borrá `public/install.php`.
5. Entrá a `/admin/`.

El detalle completo está en **[docs/INSTALACION.md](docs/INSTALACION.md)**.

## Documentación

| Documento | Contenido |
|---|---|
| [docs/INSTALACION.md](docs/INSTALACION.md) | Instalación en cPanel, DNS, SSL, permisos, problemas frecuentes |
| [docs/SEO.md](docs/SEO.md) | Palabra clave por página, schema, lista de control antes de publicar |
| [docs/ANTI-PENALIZACION.md](docs/ANTI-PENALIZACION.md) | Qué se hizo para evitar penalizaciones y qué no hacer nunca |
| [docs/analisis-competencia.md](docs/analisis-competencia.md) | Análisis del sector, palabras clave por intención, mapa sin canibalización |
| [docs/POST-LANZAMIENTO.md](docs/POST-LANZAMIENTO.md) | Plan de 90 días: Search Console, Google Business, enlaces, calendario editorial |

## Estructura

```
app/          Núcleo, controladores, modelos y vistas
  Core/       Base de datos, enrutador, sesión, CSRF, SEO, correo, subidas
  Admin/      Definición de los módulos del panel
  Views/      Plantillas del sitio y del panel
config/       Configuración (fuera del document root)
database/     Esquema SQL y contenido inicial
  content/    Páginas, servicios, portafolio, FAQ y artículos
docs/         Documentación
public/       Document root
  admin/      Panel de administración
  assets/     CSS, JS, fuentes e imágenes
  uploads/    Imágenes subidas desde el panel
storage/      Archivos internos
tools/        Utilidades de mantenimiento y verificación
```

## Utilidades

```bash
# Verificación de SEO, estructura, schema y anti-penalización
php tools/verificar.php https://paginasweb.gt

# Prueba del panel, los formularios y la seguridad
php tools/probar-panel.php https://paginasweb.gt correo@ejemplo.com "contraseña"

# Rastreo de enlaces internos rotos y páginas huérfanas
php tools/revisar-enlaces.php https://paginasweb.gt

# Regenerar CSS y JS minificados
php tools/build-assets.php

# Regenerar database/seed.sql desde el contenido inicial
php tools/exportar-seed.php

# Regenerar imágenes (requiere Chromium; solo en desarrollo)
php tools/imagenes/generar-imagenes.php
php tools/imagenes/generar-ilustraciones.php
python3 tools/imagenes/generar-logo.py

# Instalación desatendida con SQLite, solo para pruebas locales
php tools/instalar-local.php http://localhost:8080
php -S localhost:8080 -t public
```

## Sistema visual

| Elemento | Decisión |
|---|---|
| Lienzos | Obsidiana `#0A0C0F` y hueso `#F3F0E9`, alternados por sección |
| Color de señal | Verde quetzal `#11E39A`; sobre fondo claro se usa `#04684E` |
| Titulares | Instrument Serif, alto contraste, con cursiva como voz secundaria |
| Texto | Geist |
| Etiquetas y datos | Geist Mono, en versalitas con numeración `01 —` |
| Forma | Reglas capilares y marcas de esquina; sin sombras ni esquinas redondeadas |

Los cuatro colores se editan desde **/admin → Configuración → Colores de la marca**.

## Créditos de las tipografías

- **Instrument Serif** — SIL Open Font License 1.1
- **Geist** y **Geist Mono** — SIL Open Font License 1.1

Las licencias están en `public/assets/fonts/`.

Todas las imágenes del proyecto (logotipo, ilustraciones, mockups y portadas para redes)
se generaron para este sitio. No se usan fotografías de bancos de imágenes ni material
de terceros.
