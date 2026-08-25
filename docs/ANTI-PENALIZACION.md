# Anti-penalización — qué se hizo y qué no hay que hacer nunca

paginasweb.gt es un dominio nuevo que pertenece a la misma empresa que servicom.gt.
Esa situación tiene un riesgo concreto: si Google interpreta que son dos sitios que
publican lo mismo para ocupar más espacio en los resultados, puede terminar mostrando
solo uno o, en el peor caso, ninguno.

Este documento explica cómo se construyó el sitio para evitarlo y qué prácticas
concretas hay que evitar de aquí en adelante.

---

## Parte 1 — Qué se hizo

### 1.1 Contenido original

Todos los textos del sitio se escribieron desde cero para este proyecto: las 12 páginas,
las 34 preguntas frecuentes, los 6 artículos del blog, los términos y condiciones y la
política de privacidad. No se copió ni se parafraseó nada de servicom.gt ni de ningún
competidor.

El verificador comprueba automáticamente que ninguna pareja de páginas del sitio supere
el 80% de similitud entre sí.

### 1.2 Dos sitios claramente distintos

servicom.gt y paginasweb.gt tienen que verse como dos caras de la misma empresa, no
como dos sitios clonados:

- **Estructura de secciones distinta.** Este sitio se organiza por intención de búsqueda
  (servicio, precios, portafolio, guías), con bloques que servicom.gt no usa: tabla
  comparativa de los tres servicios, sección "cómo trabajamos y cómo no", bloque de
  respuesta directa para el fragmento destacado.
- **Voz distinta.** Este sitio habla en segunda persona con voseo guatemalteco y explica
  el porqué de cada decisión, incluso cuando la respuesta honesta es "no te conviene".
- **Títulos y descripciones únicos**, sin coincidencias con los del otro dominio.
- **Marca declarada.** En `/nosotros/` hay una sección completa titulada "Por qué usamos
  dos marcas", y el pie de página lo repite en una línea. Hay **un solo enlace** a
  servicom.gt por página, con anchor de marca (`servicom.gt`), no con palabra clave.

Decirle a Google explícitamente que son la misma empresa es mejor que dejar que lo
deduzca. El schema lo refuerza: `Organization.parentOrganization` apunta a Servicom.

### 1.3 Sin keyword stuffing

Cada palabra clave aparece de forma natural. El verificador mide la densidad de
"páginas web", "diseño de páginas web", "tiendas virtuales", "páginas web Guatemala" y
"Guatemala" en cada página, y **falla si alguna supera el 1.5%**.

El pie de página no contiene listas de municipios ni de palabras clave. Contiene lo que
tiene que contener: descripción de la empresa, menús reales, datos de contacto y enlaces
legales.

### 1.4 Sin texto ni enlaces ocultos

No hay texto del color del fondo, `display:none` con contenido, `text-indent` negativo
ni `font-size: 0`. El verificador revisa esos patrones en todas las páginas.

Un detalle que se corrigió durante el desarrollo: las secciones tenían una animación de
aparición que las dejaba con `opacity: 0` hasta que JavaScript las mostraba. Si el
JavaScript fallaba, el contenido quedaba invisible. Se cambió para que la clase de
animación **solo se aplique cuando JavaScript está activo**: sin JavaScript, todo se ve
normalmente.

### 1.5 Sin páginas puerta

Una intención de búsqueda, una página. No hay páginas por ciudad, ni por departamento,
ni variaciones de la misma palabra clave con el nombre de un municipio cambiado.

La única separación cercana es `/precios/` frente al artículo "cuánto cuesta una página
web en Guatemala", y responde a dos preguntas distintas: **cuánto cobramos nosotros** y
**cuánto cuesta en el mercado**.

### 1.6 Blog de calidad, no de volumen

Seis artículos, todos de más de 1,200 palabras, cada uno con datos reales de Guatemala:
Visanet Epay, la factura electrónica FEL y los certificadores autorizados por la SAT, el
registro de dominios `.gt`, las formas de pago que se usan en el país, y qué plataformas
(Stripe, Shopify Payments) directamente no operan acá.

En el propio blog está escrito el criterio editorial: se publica poco, se actualiza lo
existente en vez de duplicar, y no se hacen listas de relleno.

### 1.7 Schema honesto

Solo se marcan datos verificables. **No hay `AggregateRating` ni `Review`**, porque no
hay reseñas verificables que respalden esas afirmaciones. El verificador falla si
aparecen. Los precios del schema son los precios reales.

### 1.8 Testimonios vacíos a propósito

El módulo de testimonios existe y funciona, pero **está vacío**. El sitio muestra un
mensaje explicando por qué: es preferible una sección vacía a testimonios que nadie
pueda verificar. El panel incluye un campo para guardar el enlace de origen de cada
testimonio (Google, Facebook, LinkedIn).

### 1.9 NAP idéntico

Teléfono, WhatsApp, correo y ciudad son exactamente los mismos que los de Servicom. Se
gestionan desde un solo lugar en el panel para que no se desincronicen.

### 1.10 Sin cifras inventadas

Las métricas de la portada son verificables: 18 años (2007), 24 sitios publicados (los
que aparecen en el portafolio, todos con enlace abierto), Q250 de pago inicial, 100% del
trabajo en línea. No hay "más de 500 clientes satisfechos" ni promedios de estrellas.

Las imágenes del portafolio son **presentaciones ilustrativas**, no capturas
automáticas, y la página lo dice explícitamente. Cada tarjeta enlaza al sitio real.

### 1.11 Sin promesas de posicionamiento

En ninguna parte del sitio se promete un lugar en Google. Al contrario: en las
preguntas frecuentes, en la página de servicio, en los términos y condiciones y en un
artículo completo se explica por qué nadie puede garantizarlo.

---

## Parte 2 — Lo que NO hay que hacer nunca

Cada punto de esta lista corresponde a una práctica que Google trata explícitamente
como spam en sus políticas públicas. Todas producen resultados rápidos y todas terminan
mal.

### 2.1 Nunca copiar textos de servicom.gt a paginasweb.gt

Ni al revés. Si querés hablar del mismo tema en los dos sitios, escribí dos textos
distintos o publicalo en uno solo y enlazalo desde el otro. Contenido duplicado entre
dos dominios de la misma empresa es la forma más rápida de que Google decida ignorar
uno de los dos.

### 2.2 Nunca crear páginas por municipio o departamento

"Páginas web en Mixco", "Páginas web en Quetzaltenango", "Páginas web en Escuintla".
Es la tentación más común del SEO local y es una red de páginas puerta de manual. Si de
verdad tenés algo distinto que decir sobre un mercado local, escribí **un** artículo con
sustancia; no veinte páginas iguales con el nombre cambiado.

### 2.3 Nunca llenar el pie de página con palabras clave

Ni con listas de ciudades, ni con "diseño web Guatemala | páginas web Guatemala |
sitios web Guatemala…". El pie es para navegación y datos de contacto.

### 2.4 Nunca comprar enlaces ni entrar en intercambios masivos

Ni paquetes de "500 backlinks", ni directorios de pago que solo existen para vender
enlaces, ni intercambios recíprocos a escala. Los enlaces útiles vienen de directorios
guatemaltecos legítimos, de menciones reales y del crédito natural en el pie de los
sitios de clientes.

### 2.5 Nunca usar anchor text con palabra clave en los créditos del portafolio

En el pie de los sitios que hacemos, el crédito correcto es:

> Sitio diseñado por [paginasweb.gt](https://paginasweb.gt)

**Nunca** "diseño de páginas web en Guatemala" como texto del enlace. Veinticuatro
sitios enlazando con el mismo anchor de palabra clave es un patrón antinatural evidente.
Y **siempre con permiso del cliente**.

### 2.6 Nunca inventar testimonios, reseñas ni calificaciones

Ni en el sitio, ni en el schema, ni en Google Business Profile. Además de ser motivo de
acción manual, en Guatemala puede constituir publicidad engañosa.

### 2.7 Nunca esconder texto

Ni del color del fondo, ni fuera de la pantalla, ni detrás de un `display:none`
permanente, ni en una pestaña que nunca se abre. Si el texto no es lo bastante bueno
para mostrarlo, tampoco lo es para indexarlo.

### 2.8 Nunca generar contenido a escala

Ni cuarenta artículos automáticos al mes, ni descripciones generadas en masa. Google no
penaliza el uso de herramientas de escritura: penaliza publicar en volumen contenido
que no aporta nada. La prueba es simple: **si nadie de la empresa estaría dispuesto a
firmar el texto con su nombre, no se publica**.

### 2.9 Nunca crear un segundo perfil de Google Business

Servicom ya tiene su perfil. Crear otro para paginasweb.gt sería una duplicación de
ficha: Google suspende ambas. Lo correcto está explicado en
[POST-LANZAMIENTO.md](POST-LANZAMIENTO.md).

### 2.10 Nunca prometer el primer lugar en Google

Ni en el sitio, ni en una cotización, ni por WhatsApp.

### 2.11 Nunca cambiar una URL sin redirección 301

Si cambiás el slug de una página que ya estaba indexada, creá inmediatamente la
redirección en **/admin → Redirecciones**. Sin eso perdés el posicionamiento acumulado
y generás un 404 para quien tenía el enlace guardado.

### 2.12 Nunca dejar activada la casilla de bloqueo para buscadores

En **/admin → Configuración → Buscadores** hay una casilla para bloquear el sitio
mientras está en pruebas. Si queda activa, el sitio no aparece en Google. El escritorio
del panel muestra una alerta roja permanente si está encendida.

---

## Parte 3 — Revisión periódica

**Cada vez que publicás contenido:** la lista de control de [SEO.md](SEO.md), sección 5.

**Cada mes:**

```bash
php tools/verificar.php https://paginasweb.gt
```

Debe terminar con `Fallas: 0`.

**Cada tres meses:**

1. Buscá en Google `site:paginasweb.gt` y `site:servicom.gt`. Revisá que no haya
   páginas con títulos o descripciones repetidas entre los dos dominios.
2. Entrá a Search Console → **Seguridad y acciones manuales**. Debe decir que no se
   detectaron problemas.
3. Revisá Search Console → **Enlaces** → sitios que más enlazan. Si aparecen dominios
   de spam que no reconocés, documentalos; si el volumen es grande y sospechoso,
   considerá el archivo de rechazo (*disavow*).
4. Releé los tres artículos con más tráfico y actualizá lo que haya cambiado (precios
   del mercado, condiciones de bancos, reglas de la SAT).
