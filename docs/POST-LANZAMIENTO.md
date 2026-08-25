# Plan de 90 días después del lanzamiento

Un dominio nuevo no posiciona por tener buen contenido: posiciona cuando Google
acumula suficientes señales de que existe, funciona y le sirve a alguien. Eso toma
meses. Este plan ordena qué hacer y en qué orden.

**Regla general:** todo lo que está acá es legítimo. Nada de comprar enlaces, nada de
directorios de spam, nada de crear perfiles duplicados.

---

## Semana 1 — Poner los cimientos

### Google Search Console

1. Entrá a <https://search.google.com/search-console> y agregá la propiedad
   `https://paginasweb.gt` como **prefijo de URL**.
2. Elegí verificación por **etiqueta HTML**. Copiá solo el valor del atributo
   `content` y pegalo en **/admin → Configuración → Analítica → Verificación de
   Search Console**. Guardá y volvé a verificar.
3. Enviá el sitemap: en *Sitemaps*, escribí `sitemap.xml` y enviá.
4. En *Inspección de URLs*, pedí la indexación de las páginas principales, una por una:
   `/`, `/diseno-de-paginas-web-guatemala/`, `/tiendas-virtuales-guatemala/`,
   `/precios/`, `/portafolio/`, `/nosotros/`.

### Google Analytics 4

1. Creá una propiedad en <https://analytics.google.com>.
2. Copiá el ID de medición (empieza con `G-`) y pegalo en
   **/admin → Configuración → Analítica**.
3. Verificá en *Informes → Tiempo real* que se registren tus propias visitas.
4. Marcá como conversiones: envíos del formulario y clics al botón de WhatsApp.

### Bing Webmaster Tools

Toma cinco minutos y permite importar la configuración desde Search Console.
No mueve la aguja en volumen, pero es tráfico gratis: <https://www.bing.com/webmasters>

### Comprobaciones finales

- [ ] `https://paginasweb.gt` abre con candado.
- [ ] `www.paginasweb.gt` redirige a la versión sin `www`.
- [ ] `http://` redirige a `https://`.
- [ ] `/sitemap.xml` y `/robots.txt` responden correctamente.
- [ ] La casilla "Bloquear el sitio para los buscadores" está **desactivada**.
- [ ] `public/install.php` fue borrado del servidor.
- [ ] Llegó el correo de prueba desde **/admin → Herramientas**.
- [ ] `php tools/verificar.php https://paginasweb.gt` termina con `Fallas: 0`.

---

## Semana 2 — Vincular el dominio al perfil de Google existente

**No crees un segundo perfil de Google Business.** Servicom ya tiene el suyo. Dos fichas
para la misma empresa, la misma dirección y el mismo teléfono es una duplicación: Google
suele suspender las dos.

Lo correcto:

1. Entrá al **perfil existente de Servicom** en <https://business.google.com>.
2. En **Información del perfil → Sitio web**, decidí cuál de los dos dominios querés
   que sea el sitio principal de la ficha.
   - Si el objetivo comercial es que paginasweb.gt sea la cara del servicio de sitios
     web, poné `https://paginasweb.gt` como sitio web del perfil.
   - Si preferís no tocarlo, dejá servicom.gt como sitio principal y usá paginasweb.gt
     en los enlaces de los productos y servicios del perfil (siguiente punto).
3. En **Productos** o **Servicios** del perfil, agregá los tres servicios con su enlace
   correspondiente: `/diseno-de-paginas-web-guatemala/`, `/tiendas-virtuales-guatemala/`
   y `/cuentas-de-correo-corporativo/`. Ahí sí podés enlazar a paginasweb.gt sin
   ambigüedad.
4. En **Publicaciones**, empezá a publicar hacia el sitio nuevo.
5. Confirmá que el nombre, el teléfono y la dirección del perfil coincidan **exactamente**
   con los de **/admin → Configuración → Contacto** y con los de servicom.gt. Cualquier
   diferencia (un "+502" que en un lado está y en otro no) debilita la señal local.

### Cómo pedir reseñas sin meterse en problemas

- Pedilas solo a clientes reales, después de entregar un trabajo.
- Mandá el enlace corto que genera el perfil ("Pedir reseñas").
- **Nunca** ofrezcas descuentos o regalos a cambio de una reseña: viola las políticas
  de Google y puede costar la ficha.
- Respondé todas las reseñas, incluidas las malas, con calma y sin discutir.
- Cuando tengas reseñas reales, cargalas en **/admin → Testimonios** con el enlace de
  origen en el campo correspondiente.

---

## Semanas 3 y 4 — Créditos en los sitios del portafolio

Los 24 sitios del portafolio son la fuente de enlaces más legítima y valiosa que tiene
el proyecto: son sitios reales, de sectores distintos, con dominios propios.

### Cómo hacerlo bien

En el pie de página de cada sitio de cliente, el crédito correcto es:

```html
Sitio diseñado por <a href="https://paginasweb.gt">paginasweb.gt</a>
```

**Reglas que no se rompen:**

1. **Anchor de marca.** El texto del enlace es `paginasweb.gt`. Nunca "diseño de
   páginas web en Guatemala" ni ninguna variante con palabra clave. Veinticuatro sitios
   con el mismo anchor de palabra clave es un patrón antinatural evidente.
2. **Con permiso.** Pedile autorización al cliente antes de agregarlo. Es su sitio.
3. **De a poco.** Agregá cuatro o cinco por semana, no los 24 el mismo día. Un dominio
   nuevo que gana 24 enlaces en 24 horas levanta sospecha.
4. **Enlace normal**, sin `rel="nofollow"` ni `rel="sponsored"`: es un crédito genuino
   de autoría, no publicidad pagada.
5. **Uno por sitio.** Solo en el pie. Nada de repetirlo en cada página del cliente
   como bloque destacado.

### Orden sugerido

| Semana | Sitios |
|---|---|
| 3 | Los cinco con los que tenés mejor relación y que ya te dieron el visto bueno |
| 3 | Cinco más, de sectores distintos |
| 4 | Otros cinco |
| 4 | Otros cinco |
| 5 | Los cuatro restantes |

Anotá en una hoja qué sitio, qué fecha y si el cliente autorizó.

---

## Mes 2 — Directorios y menciones legítimas

El objetivo no es "conseguir enlaces": es que la empresa aparezca donde alguien la
podría estar buscando, con datos consistentes.

### Directorios guatemaltecos que vale la pena

| Directorio | Por qué |
|---|---|
| Google Business Profile | Ya cubierto en la semana 2 |
| Páginas Amarillas Guatemala (`paginasamarillas.com.gt`) | Directorio local con tráfico real |
| Guatemala.com — directorio de empresas | Portal grande y establecido |
| Deguate.com / Deguate.gt — directorio | Uno de los portales más antiguos del país |
| Cámara de Comercio de Guatemala | Si la empresa está afiliada, aparecer en su directorio es una mención de peso |
| Cámara de Industria de Guatemala | Ídem |
| LinkedIn — página de empresa | Perfil de marca, con enlace al sitio |

**Cómo cargarlos correctamente:**

- Usá **exactamente** el mismo nombre, teléfono y dirección en todos. Copiá y pegá
  desde **/admin → Configuración**, no lo escribas de memoria.
- Descripción distinta en cada uno. No pegues el mismo párrafo en los diez.
- Si el directorio ya tiene una ficha de Servicom, **actualizá esa** en vez de crear una
  nueva.

**Directorios que hay que evitar:** cualquiera que cobre por "posicionamiento
garantizado", los que aceptan cualquier sitio sin revisión, y las listas de "500
directorios por US$20". Esos son granjas de enlaces.

### Menciones que se ganan, no se compran

- Escribile a los clientes del portafolio y preguntales si tienen boletín o redes donde
  puedan mencionar el sitio nuevo.
- Si un artículo del blog le sirve a una cámara empresarial o a una asociación de
  emprendedores, ofrecelo como contenido útil, no como publicidad.
- Respondé preguntas reales en grupos de emprendedores guatemaltecos. Sin spam: aportá
  la respuesta completa y enlazá solo si el artículo agrega algo.

---

## Mes 3 — Contenido y medición

### Calendario editorial mensual

Un artículo al mes es suficiente y sostenible. Publicar más y peor no ayuda.

| Mes | Tema sugerido | Palabra clave objetivo |
|---|---|---|
| 4 | Cómo preparar las fotos de tu negocio con un celular | fotos para página web |
| 5 | Qué mirar en Google Analytics si no sos técnico | analytics para negocios |
| 6 | Facturación electrónica FEL y tu tienda en línea | FEL tienda en línea Guatemala |
| 7 | Cómo escribir la página "Nosotros" de tu empresa | página nosotros empresa |
| 8 | Hosting: qué mirar antes de contratar en Guatemala | hosting Guatemala |
| 9 | Cómo migrar tu sitio sin perder posicionamiento | migrar sitio web |

Cada tema tiene que salir de una pregunta que te hayan hecho clientes reales. Si no
recordás que alguien la haya preguntado, no la escribas.

**Además de publicar:** dedicá una hora al mes a **actualizar** un artículo existente.
Revisar precios, condiciones de bancos y reglas de la SAT vale más que un artículo
nuevo mediocre.

### Métricas semanales (10 minutos, los lunes)

Anotá estos cinco números en una hoja de cálculo:

| Métrica | Dónde | Qué mirar |
|---|---|---|
| Impresiones | Search Console → Rendimiento | Que suban mes a mes |
| Clics | Search Console → Rendimiento | Que suban junto con las impresiones |
| Posición media de "páginas web Guatemala" | Search Console → filtrar consulta | La tendencia, no el número exacto |
| Páginas indexadas | Search Console → Indexación | Deberían ser 18. Si bajan, revisá por qué |
| Formularios recibidos | /admin → Mensajes | Es la única métrica que paga las cuentas |

### Qué esperar de forma realista

| Momento | Qué es normal |
|---|---|
| Semanas 1–2 | Google descubre el sitio. Las primeras páginas se indexan |
| Semanas 3–6 | Aparecen impresiones para búsquedas de marca y de cola larga |
| Meses 2–3 | Los artículos del blog empiezan a traer visitas informativas |
| Meses 4–6 | Las páginas comerciales entran en la segunda página para las principales |
| Meses 6–12 | Con contenido y enlaces sostenidos, primera página para las principales |

Un dominio nuevo compitiendo contra sitios de 10 y 20 años **no llega al primer lugar
en tres meses**. Cualquiera que prometa lo contrario está vendiendo humo o está a punto
de usar técnicas que van a costar el dominio.

---

## Señales de alerta

Revisalas cada mes. Si aparece alguna, actuá de inmediato.

| Señal | Qué significa | Qué hacer |
|---|---|---|
| Caída brusca de impresiones (más del 50% en una semana) | Cambio de algoritmo o problema técnico | Revisá Search Console → Indexación y Acciones manuales |
| Mensaje de acción manual en Search Console | Google detectó una violación de políticas | Leé el motivo, corregí y pedí reconsideración. Consultá [ANTI-PENALIZACION.md](ANTI-PENALIZACION.md) |
| Páginas desindexadas | Contenido duplicado o `noindex` accidental | Revisá la casilla de indexación de esa página y compará con servicom.gt |
| Enlaces entrantes de dominios de spam | Alguien te está haciendo SEO negativo, o un directorio malo | Documentalos; si el volumen es grande, usá el archivo de rechazo |
| El sitio desaparece de las búsquedas de marca | Problema técnico grave | Revisá `robots.txt`, la casilla de bloqueo y que el SSL esté vigente |

---

## Lo que solo vos podés hacer

Esta lista queda pendiente porque requiere accesos o decisiones que no están en el
código:

- [ ] Apuntar el DNS del dominio al hosting.
- [ ] Activar el certificado SSL en cPanel.
- [ ] Crear la base de datos y ejecutar `install.php`.
- [ ] Confirmar el **horario de atención real** y ajustarlo en el panel.
- [ ] Crear la propiedad de Google Analytics 4 y pegar el ID.
- [ ] Verificar Search Console y enviar el sitemap.
- [ ] Decidir si el perfil de Google Business apunta a paginasweb.gt o a servicom.gt.
- [ ] Pedir autorización a los clientes del portafolio para el crédito en el pie.
- [ ] Recoger y cargar los testimonios reales, con su enlace de origen.
- [ ] Cargar las redes sociales que existan (el sitio no muestra las que estén vacías).
- [ ] Confirmar si los precios publicados siguen vigentes al momento de lanzar.
