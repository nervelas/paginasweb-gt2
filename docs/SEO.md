# SEO de paginasweb.gt — mapa, datos estructurados y lista de control

Este documento describe cómo está armado el SEO del sitio y qué hay que revisar cada
vez que se agrega o se cambia contenido.

---

## 1. Palabra clave por página

Una intención de búsqueda por página. Si alguna vez querés atacar una palabra clave
nueva, revisá primero si ya hay una página que responde esa misma intención: si la hay,
**mejorá esa página** en lugar de crear otra.

| URL | Palabra clave principal | Title (≤60) | Description (≤155) |
|---|---|---|---|
| `/` | páginas web Guatemala | Páginas Web en Guatemala \| Diseño desde Q1,250 | 144 caracteres |
| `/diseno-de-paginas-web-guatemala/` | diseño de páginas web Guatemala | Diseño de Páginas Web en Guatemala \| paginasweb.gt | 148 |
| `/tiendas-virtuales-guatemala/` | tiendas virtuales Guatemala | Tiendas Virtuales en Guatemala \| WooCommerce y tarjeta | 146 |
| `/precios/` | precios de páginas web Guatemala | Precios de Páginas Web en Guatemala 2026 \| Q1,250 | 141 |
| `/cuentas-de-correo-corporativo/` | correo corporativo Guatemala | Correo Corporativo con tu Dominio \| Guatemala | 152 |
| `/portafolio/` | portafolio diseño web Guatemala | Portafolio de Páginas Web en Guatemala \| Trabajos | 152 |
| `/nosotros/` | empresa de diseño web Guatemala | Nosotros \| paginasweb.gt, una marca de Servicom | 153 |
| `/preguntas-frecuentes/` | preguntas sobre páginas web | Preguntas Frecuentes sobre Páginas Web \| Guatemala | 132 |
| `/contacto/` | cotizar página web Guatemala | Contacto \| Cotizá tu Página Web en Guatemala | 142 |
| `/blog/` | (índice, sin objetivo) | Blog de Páginas Web y Tiendas en Línea \| Guatemala | 149 |
| `/blog/cuanto-cuesta-una-pagina-web-en-guatemala/` | cuánto cuesta una página web en Guatemala | Cuánto Cuesta una Página Web en Guatemala 2026 | 141 |
| `/blog/como-crear-tienda-en-linea-guatemala/` | cómo crear una tienda en línea en Guatemala | Cómo Crear una Tienda en Línea en Guatemala \| Guía | 142 |
| `/blog/woocommerce-vs-shopify-guatemala/` | WooCommerce vs Shopify Guatemala | WooCommerce vs Shopify en Guatemala \| Comparación | 143 |
| `/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/` | cobrar con tarjeta sitio web Guatemala | Cómo Cobrar con Tarjeta en tu Sitio Web en Guatemala | 152 |
| `/blog/dominio-gt-como-registrarlo/` | dominio .gt cómo registrarlo | Qué es un Dominio .gt y Cómo Registrarlo \| Guatemala | 147 |
| `/blog/errores-al-contratar-diseno-web-guatemala/` | errores al contratar diseño web | 7 Errores al Contratar Diseño Web en Guatemala | 144 |

Los `title` y las `meta description` se editan desde **/admin → Páginas** y
**/admin → Blog**. El panel muestra un contador de caracteres en vivo.

---

## 2. Estructura de encabezados

- **Un solo `H1` por página**, que es el campo "Título principal" del panel.
- Los `H2` son las secciones; los `H3`, subsecciones dentro de un `H2`.
- **Nunca se salta un nivel** (no hay `H4` colgando de un `H2`). Los títulos del pie de
  página usan `H2` justamente por eso.
- Los encabezados describen el contenido, no repiten la palabra clave.

---

## 3. Datos estructurados (JSON-LD)

Todo el schema se emite en un solo bloque `@graph` por página, desde
`app/Core/Seo.php`. **Regla del proyecto: solo se marcan datos reales.**

| Tipo | Dónde | Contenido |
|---|---|---|
| `Organization` | Todas | Nombre, razón social, logo, correo, teléfono, dirección, año de fundación, `parentOrganization` → Servicom |
| `ProfessionalService` | Todas menos el blog | NAP, rango de precios, moneda GTQ, `areaServed` Guatemala, horario (si está configurado) |
| `WebSite` | Todas | URL, idioma `es-GT`, editor |
| `BreadcrumbList` | Todas menos el inicio | Ruta real de navegación |
| `Service` + `Offer` / `AggregateOffer` | Páginas de servicio y `/precios/` | Precio real en GTQ, disponibilidad |
| `FAQPage` | Páginas con preguntas cargadas | Se genera solo desde las preguntas visibles de esa página |
| `Article` | Artículos del blog | Titular, fechas, imagen, autor, editor |

**Lo que NO se marca, a propósito:**

- `AggregateRating` y `Review`: no hay reseñas verificables. Inventarlas es motivo de
  acción manual por parte de Google y, además, publicidad engañosa.
- `Product` para los servicios: son servicios, no productos.
- Horario, si el campo `opening_hours_spec` se deja vacío en el panel.

El bloque FAQ se genera automáticamente: **si agregás una pregunta desde el panel, el
schema se actualiza solo**. Por eso importa que las respuestas sean respuestas de
verdad y no ganchos de venta.

Para verificar: <https://search.google.com/test/rich-results>

---

## 4. SEO técnico implementado

| Elemento | Estado |
|---|---|
| URLs limpias con barra final | Sí, con redirección 301 automática desde la versión sin barra |
| `canonical` en todas las páginas | Sí, autogenerado; editable por página |
| `hreflang` `es-gt` y `x-default` | Sí |
| `meta robots` por página | Sí, casilla "Permitir que Google la indexe" |
| Open Graph y Twitter Card | Sí, con imagen 1200×630 propia por página |
| `sitemap.xml` dinámico | Sí, solo con páginas indexables |
| `robots.txt` dinámico | Sí; bloquea `/admin/`, `/install.php` y `/blog/categoria/` |
| Redirecciones 301 administrables | Sí, módulo propio en el panel |
| HTTPS forzado y `www` → sin `www` | Sí, en `.htaccess` |
| Cabeceras de seguridad + CSP | Sí, compatibles con GA4 y Meta Pixel |
| Compresión y caché del navegador | Sí (gzip/brotli, `immutable` para estáticos) |
| Imágenes WebP con dimensiones declaradas | Sí, sin desplazamiento de diseño |
| Fuentes autoalojadas con `font-display: swap` | Sí, 104 KB en total (subconjunto latino) |
| CSS crítico en línea, resto diferido | Sí |
| Página 404 propia con código 404 real | Sí |

Las categorías del blog están en `noindex, follow` a propósito: con seis artículos,
indexar cinco listados de una o dos entradas cada uno solo generaría páginas de poco
valor.

---

## 5. Lista de control antes de publicar contenido nuevo

Pegá esta lista en el panel o imprimila. Toma dos minutos y evita la mayoría de los
problemas.

**Contenido**

- [ ] El texto es original. No se copió ni se parafraseó de otro sitio, incluido servicom.gt.
- [ ] Responde una duda real que te hayan hecho clientes.
- [ ] Los datos concretos (precios, plazos, nombres de bancos o plataformas) están verificados.
- [ ] Se lee natural en voz alta. Si una frase suena forzada por meter la palabra clave, se reescribe.
- [ ] Tiene al menos 900 palabras si es página de servicio, o 1,200 si es artículo.

**En página**

- [ ] `Title` de 60 caracteres o menos, con la palabra clave al principio.
- [ ] `Meta description` de 155 o menos, que invite a hacer clic (no es un resumen).
- [ ] Un solo `H1`.
- [ ] Los `H2` y `H3` van en orden, sin saltarse niveles.
- [ ] Dos o tres enlaces internos contextuales, con anchor descriptivo (no "clic aquí").
- [ ] Imagen destacada en WebP, con texto alternativo que describa la imagen.
- [ ] Ninguna otra página del sitio responde esa misma intención de búsqueda.

**Después de publicar**

- [ ] La página aparece en `/sitemap.xml`.
- [ ] Se ve bien en el celular.
- [ ] Se pidió la indexación en Search Console.
- [ ] Se ejecutó `php tools/verificar.php https://paginasweb.gt` y salió sin fallas.

---

## 6. Herramientas del proyecto

```bash
# Verificación completa de SEO, estructura y anti-penalización
php tools/verificar.php https://paginasweb.gt

# Prueba del panel y de los formularios
php tools/probar-panel.php https://paginasweb.gt correo@ejemplo.com "contraseña"

# Regenerar CSS y JS minificados después de editar los archivos fuente
php tools/build-assets.php
```

`tools/verificar.php` revisa: códigos de respuesta, longitud y unicidad de títulos y
descripciones, un solo `H1`, canonical, `og:image`, `hreflang`, extensión mínima de
contenido, imágenes con `alt` y dimensiones, existencia de los archivos de imagen,
validez y contenido del JSON-LD, densidad de palabras clave, texto oculto, enlace a la
marca madre, `robots.txt`, `sitemap.xml`, la 404, contenido duplicado interno, sintaxis
PHP y compatibilidad con PHP 7.4.
