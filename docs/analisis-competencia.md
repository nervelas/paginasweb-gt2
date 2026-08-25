# Análisis de competencia — páginas web en Guatemala

**Fecha del análisis:** agosto de 2026
**Objetivo:** ubicar a paginasweb.gt en los primeros lugares de Google Guatemala para
"páginas web Guatemala", "diseño de páginas web Guatemala" y "tiendas virtuales Guatemala",
usando exclusivamente técnicas que cumplen las políticas de spam de Google.

---

## 0. Nota sobre el método y sus límites

El entorno donde se ejecutó este proyecto tiene la salida a internet restringida por
política de red: las peticiones directas a los dominios de la competencia y a
`servicom.gt` fueron rechazadas por el proxy (`EGRESS_BLOCKED`). Se reintentó por dos
vías (WebFetch y `curl`) sin éxito.

Por eso el análisis se construyó con:

1. **Resultados de búsqueda** (títulos, descripciones y fragmentos que Google indexa
   de cada competidor). Esto da acceso fiable al `title`, a la `meta description` y a
   parte del contenido posicionado, que es justamente lo que compite en el SERP.
2. **Estructura de URLs** visible en los resultados.
3. **Precios publicados** que aparecen en los fragmentos indexados.

**Lo que quedó fuera y hay que completar manualmente:** jerarquía completa de H1–H3,
schema implementado, extensión exacta del contenido y velocidad de carga de cada
competidor. En la sección 6 hay una guía de 20 minutos para completarlo desde una
computadora con salida a internet.

Ninguna decisión de contenido de este proyecto depende de esos datos faltantes: la
estrategia es de contenido original y superior, no de copiar al competidor.

---

## 1. Tabla comparativa

| Competidor | Título indexado (aprox.) | Posicionamiento | Precios públicos | Debilidad aprovechable |
|---|---|---|---|---|
| **bluearksolutions.com** | "Páginas Web Guatemala Diseño Web" | Agencia con 10 años, varias páginas de precios | Renovación Q2,500/año (dominio + hosting + soporte); mantenimiento Q800–Q2,000/mes | Tiene **cuatro páginas distintas sobre precios** (`/precios-de-paginas-web/`, `/precios-y-planes-de-paginas-web/`, `/cuanto-cuesta-una-pagina-web/`, `/empresas-de-diseno-web-en-guatemala/`). Es canibalización clásica: se reparten la autoridad entre sí. |
| **bluearksolutions.com/precios-de-paginas-web/** | "Precios de Páginas Web Guatemala" | Página de precios | Sí | Compite contra sus propias páginas hermanas por la misma intención. |
| **compuweb.com.gt** | "Diseño de Páginas Web en Guatemala \| Hosting \| Dominios \| Tienda en línea" | El competidor más completo: web, tiendas, WooCommerce, PrestaShop, marketing, hosting, SEO | No publicados en el fragmento | **Title sobrecargado** con pipes y palabras clave apiladas; se trunca en el SERP. Ofrece demasiados servicios, lo que diluye el mensaje. |
| **cweb.gt** | "Páginas Web Guatemala - Creación y Diseño de Páginas Web" | Dominio `.gt` corto y con la keyword exacta | No publicados | El title **repite "páginas web" dos veces**: se lee como relleno y desperdicia caracteres útiles. Sin precios visibles, pierde a quien compara. |
| **ideaweb.gt** | "Ideaweb - Diseño y desarrollo de páginas web - Guatemala" | Enfoque en paquetes accesibles | No publicados | El title **empieza por la marca**, no por la palabra clave. Una marca sin reconocimiento en primera posición desperdicia el peso del título. |
| **livecorepixel.com** | "Diseño de Páginas Web en Guatemala \| LiveCorePixel Agencia Digital" | Web, ecommerce, SEO, hosting | No publicados | Sin precios y con propuesta de agencia generalista. |
| **paginaswebguatemala.com** | "Páginas Web Guatemala - Creación de páginas web" | Dominio de coincidencia exacta | Sí, `/precios/` | Los resultados indican **problemas técnicos intermitentes** en el sitio principal. Un dominio de coincidencia exacta sin contenido sólido detrás rinde poco desde 2012. |
| **paginaswebguatemala.net** | "Páginas Web Guatemala Precios" | Variante `.net` del anterior | Q800–Q1,200 (diseño) | Coexistir con el `.com` casi homónimo genera confusión de marca y sospecha de red de dominios. |
| **paginasweb.com.gt** | "Tiendas Virtuales \| Paginas Web Guatemala" | Web + tiendas | No visibles | **Sin tilde en "Páginas"** en el propio title. Detalle menor pero delata poco cuidado editorial. |
| **paginaswebgo.com** | "Páginas Web Guatemala - Páginas Web Go" | WordPress, Wix, Shopify, Google Sites | Sí, `/precios-de-paginas-web/` | Presume **"más de 600 diseños para elegir"**: es exactamente el argumento de plantilla reciclada contra el que se puede posicionar un servicio a la medida. |
| **paginaswebparatodos.com** | "PAGINAS WEB GUATEMALA \| PRECIOS \| Paginas Web, diseño web, diseño de paginas web, Hosting Guatemala…" | Sitio antiguo, `.html` | Sí, `precios.html` | **El title es una lista de palabras clave separadas por comas.** Es keyword stuffing de manual y además sirve solo con `http://`. Técnicamente obsoleto. |
| **guateportal.com** | "Diseño de páginas web Guatemala \| Guateportal" | Desde 2003, en Antigua Guatemala; portales y aplicaciones | No publicados | Muy consolidado y con trayectoria real. Su enfoque es corporativo y de proyecto grande: deja libre el segmento PyME con precio cerrado. |
| **deguate.gt/servicios/disenos-de-sitios-web/** | "Diseño de sitios web en Guatemala - Deguate.gt" | Sección de servicios dentro de un portal grande | **Desde Q1,275 todo incluido**; básica en 7 días hábiles | Es una sección dentro de un portal generalista: el dominio tiene autoridad, pero la página no está construida como oferta de agencia. Su precio es la referencia directa de nuestro rango. |
| **deztechs.com/pagina-web-en-guatemala/** | "Página web en Guatemala" | Página de servicio | No visibles | Baja presencia en los resultados; poca profundidad de contenido. |

### Patrones que se repiten en todo el sector

1. **Casi nadie publica precios completos.** Los que lo hacen (Blue Ark, Deguate,
   paginaswebguatemala.net, paginaswebgo) lo hacen a medias: dicen el precio de diseño
   pero no el de renovación, o al revés. La búsqueda "cuánto cuesta una página web en
   Guatemala" tiene demanda constante y ninguna respuesta directa y completa.
2. **Los títulos están mal construidos.** Repeticiones, marcas al inicio, listas de
   palabras clave, pipes de más. Varios se truncan en el SERP.
3. **Canibalización interna.** Blue Ark con cuatro páginas de precios es el ejemplo
   extremo, pero el patrón se repite: varias páginas para la misma intención.
4. **Contenido genérico.** Los textos podrían servir para cualquier país. Casi ninguno
   menciona Visanet Epay, FEL, el registro de dominios `.gt` ni los bancos locales.
5. **Blogs abandonados o inexistentes.** Casi ninguno tiene contenido que responda las
   preguntas previas a la compra.
6. **Cero transparencia sobre la titularidad del dominio y la renovación**, que son
   justo las dos dudas que más frenan una contratación.

---

## 2. Palabras clave por intención

Las palabras clave se agrupan por **intención de búsqueda**, no por volumen. Cada grupo
se atiende con **una sola página**, para no canibalizar.

### 2.1 Principal (comercial / servicio)

| Palabra clave | Intención | Página destino |
|---|---|---|
| páginas web Guatemala | Comercial | `/` |
| páginas web en Guatemala | Comercial | `/` |
| diseño de páginas web Guatemala | Comercial | `/diseno-de-paginas-web-guatemala/` |
| diseño web Guatemala | Comercial | `/diseno-de-paginas-web-guatemala/` |
| creación de páginas web Guatemala | Comercial | `/diseno-de-paginas-web-guatemala/` |
| tiendas virtuales Guatemala | Comercial | `/tiendas-virtuales-guatemala/` |
| tienda en línea Guatemala | Comercial | `/tiendas-virtuales-guatemala/` |

### 2.2 Secundarias (servicio ampliado)

| Palabra clave | Página destino |
|---|---|
| diseño de sitios web Guatemala | `/diseno-de-paginas-web-guatemala/` |
| páginas web para empresas Guatemala | `/diseno-de-paginas-web-guatemala/` |
| desarrollo de tiendas en línea Guatemala | `/tiendas-virtuales-guatemala/` |
| ecommerce Guatemala | `/tiendas-virtuales-guatemala/` |
| WooCommerce Guatemala | `/tiendas-virtuales-guatemala/` |
| correo corporativo Guatemala | `/cuentas-de-correo-corporativo/` |
| correo con dominio propio | `/cuentas-de-correo-corporativo/` |
| empresa de diseño web en Guatemala | `/nosotros/` |
| portafolio diseño web Guatemala | `/portafolio/` |

### 2.3 De precio (intención transaccional temprana)

| Palabra clave | Página destino |
|---|---|
| cuánto cuesta una página web en Guatemala | `/precios/` (bloque de respuesta directa) |
| precios de páginas web Guatemala | `/precios/` |
| precio diseño web Guatemala | `/precios/` |
| cuánto cuesta una tienda en línea en Guatemala | `/precios/` |
| cuánto cuesta una página web en Guatemala 2026 | `/blog/cuanto-cuesta-una-pagina-web-en-guatemala/` |
| páginas web económicas Guatemala | `/precios/` |

> El reparto entre `/precios/` y el artículo del blog es deliberado: la página de
> precios responde **"cuánto cobran ustedes"** y el artículo responde **"cuánto cuesta
> en el mercado"**. Son dos intenciones distintas y no compiten entre sí.

### 2.4 Long-tail informativa (blog)

| Palabra clave | Página destino |
|---|---|
| cómo crear una tienda en línea en Guatemala | `/blog/como-crear-tienda-en-linea-guatemala/` |
| cómo vender por internet en Guatemala | `/blog/como-crear-tienda-en-linea-guatemala/` |
| WooCommerce vs Shopify | `/blog/woocommerce-vs-shopify-guatemala/` |
| qué plataforma usar para vender en línea Guatemala | `/blog/woocommerce-vs-shopify-guatemala/` |
| cómo cobrar con tarjeta en mi página web | `/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/` |
| pasarela de pagos Guatemala | `/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/` |
| Visanet Epay cómo funciona | `/blog/como-cobrar-con-tarjeta-sitio-web-guatemala/` |
| qué es un dominio .gt | `/blog/dominio-gt-como-registrarlo/` |
| cómo registrar un dominio .gt | `/blog/dominio-gt-como-registrarlo/` |
| dominio .com.gt precio | `/blog/dominio-gt-como-registrarlo/` |
| errores al contratar diseño web | `/blog/errores-al-contratar-diseno-web-guatemala/` |
| cómo elegir una agencia de diseño web | `/blog/errores-al-contratar-diseno-web-guatemala/` |

### 2.5 Correo y alojamiento

| Palabra clave | Página destino |
|---|---|
| cuentas de correo con mi dominio | `/cuentas-de-correo-corporativo/` |
| por qué mis correos caen en spam | `/cuentas-de-correo-corporativo/` (FAQ) |
| hosting con dominio Guatemala | `/precios/` |

### 2.6 Latinoamérica (secundaria, sin páginas dedicadas)

Servicom atiende también clientes fuera de Guatemala. **No se crean páginas por país**:
eso sería una red de páginas puerta. La cobertura regional se menciona de forma natural
en `/nosotros/` y en `/contacto/` ("trabajamos 100% en línea"), y el schema declara
`areaServed: Guatemala`, que es lo verificable.

---

## 3. Mapa keyword → URL (sin canibalización)

| URL | Intención única que atiende | Palabra clave principal |
|---|---|---|
| `/` | Quién es la empresa y qué ofrece, visión general | páginas web Guatemala |
| `/diseno-de-paginas-web-guatemala/` | Quiero un sitio informativo/corporativo | diseño de páginas web Guatemala |
| `/tiendas-virtuales-guatemala/` | Quiero vender en línea | tiendas virtuales Guatemala |
| `/precios/` | Cuánto cobran ustedes | precios de páginas web Guatemala |
| `/cuentas-de-correo-corporativo/` | Quiero correo con mi dominio | correo corporativo Guatemala |
| `/portafolio/` | Quiero ver trabajos anteriores | portafolio diseño web Guatemala |
| `/nosotros/` | Quiénes son y si son confiables | empresa de diseño web Guatemala |
| `/preguntas-frecuentes/` | Dudas operativas antes de contratar | preguntas sobre páginas web |
| `/blog/` | Índice editorial | (sin keyword objetivo) |
| `/blog/<6 artículos>` | Una duda informativa cada uno | ver sección 2.4 |
| `/contacto/` | Quiero cotizar | contacto (marca) |
| `/terminos-y-condiciones/`, `/politica-de-privacidad/` | Legal | (noindex-friendly, indexadas sin objetivo) |

**Regla de oro aplicada:** una intención, una URL. Ninguna página se creó por variación
de la misma palabra clave, ni por ciudad, ni por departamento.

### Enlazado interno planificado

- `/` enlaza a los tres servicios, a `/precios/`, a `/portafolio/` y a tres artículos.
- Cada página de servicio enlaza a `/precios/`, al otro servicio relevante, a un
  artículo del blog relacionado y a `/portafolio/`.
- `/precios/` enlaza a las tres páginas de servicio y a dos artículos.
- Cada artículo enlaza a la página de servicio correspondiente y a uno o dos artículos
  hermanos.
- El pie de página enlaza una sola vez a `servicom.gt`, con anchor de marca.

---

## 4. Brechas que cubrimos

| Brecha detectada en el sector | Cómo la cubre paginasweb.gt |
|---|---|
| Nadie responde de forma directa y completa "cuánto cuesta" | Bloque de respuesta corta al inicio de `/precios/`, con los tres precios, el pago inicial y el saldo, más FAQ de precios con schema `FAQPage` |
| Renovación anual no explicada | Explicada en `/precios/`, en las FAQ y en los términos y condiciones |
| Titularidad del dominio nunca aclarada | Declarada explícitamente en tres lugares distintos |
| Contenido genérico sin datos locales | Seis guías con Visanet Epay, FEL/SAT, dominios `.gt`, bancos y formas de pago guatemaltecas |
| Títulos mal construidos | Todos los `title` bajo 60 caracteres, con la palabra clave al inicio y sin repeticiones |
| Sin datos estructurados o mal implementados | `Organization`, `ProfessionalService`, `WebSite`, `Service`, `Offer`, `FAQPage`, `BreadcrumbList` y `Article`, únicamente con datos reales |
| Sitios lentos y pesados | 98–100 en Lighthouse móvil en las cuatro categorías |
| Portafolio sin enlaces verificables | 24 proyectos con enlace directo al sitio en línea |
| Testimonios inventados | Módulo vacío hasta cargar testimonios reales y verificables |
| Comparativas que atacan a la competencia por nombre | Sección "cómo trabajamos y cómo no", sin nombrar a nadie |

---

## 5. Estrategia de diferenciación en el SERP

Contra competidores que no publican precios, el diferencial es la **transparencia**:
el fragmento de `/precios/` está escrito para poder ser tomado como *featured snippet*
de "cuánto cuesta una página web en Guatemala" — respuesta en la primera oración, cifra
concreta, sin rodeos.

Contra competidores que sí publican precios, el diferencial es **qué incluye**: somos
los únicos que declaramos en la misma tabla el precio anual, el pago inicial, el saldo y
la titularidad del dominio.

---

## 6. Cómo completar este análisis (20 minutos, desde una computadora con internet)

Para cada competidor de la tabla:

1. Abrí la página en el navegador y presioná `Ctrl+U` para ver el código.
   Anotá el `<title>`, la `meta description` y si hay `<link rel="canonical">`.
2. Instalá una extensión de estructura de encabezados (o ejecutá en la consola
   `document.querySelectorAll('h1,h2,h3').forEach(h=>console.log(h.tagName,h.innerText))`)
   y anotá si hay más de un `H1` y si la jerarquía salta niveles.
3. Pegá la URL en <https://search.google.com/test/rich-results> para ver qué schema
   tiene implementado.
4. Contá palabras con `document.body.innerText.split(/\s+/).length` en la consola.
5. Pasá la URL por <https://pagespeed.web.dev/> y anotá el puntaje móvil.
6. Buscá en Google `site:dominio.com` para ver cuántas páginas tiene indexadas y
   detectar canibalización.

Volcá los resultados en la tabla de la sección 1. La estrategia de contenido no cambia
con esos datos: sirven para priorizar contra quién competir primero.
