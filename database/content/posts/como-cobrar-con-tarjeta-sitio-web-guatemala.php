<?php
return [
    'slug'  => 'como-cobrar-con-tarjeta-sitio-web-guatemala',
    'title' => 'Cómo cobrar con tarjeta en tu sitio web en Guatemala',
    'category' => 'pagos',
    'published_at' => '2026-04-08 09:00:00',
    'image' => '/assets/img/blog/cobrar-con-tarjeta-guatemala.svg',
    'image_alt' => 'Ilustración de un pago con tarjeta en una tienda en línea',
    'meta_title' => 'Cómo Cobrar con Tarjeta en tu Sitio Web en Guatemala',
    'meta_description' => 'Qué pasarelas de pago funcionan en Guatemala, cómo es la afiliación con el banco, qué comisiones esperar y cuándo conviene activar el cobro con tarjeta.',
    'excerpt' => 'Pasarelas disponibles, el trámite de afiliación, las comisiones reales y cuándo conviene esperar antes de activarlo.',
    'body' => <<<'HTML'
<p>"Quiero que la gente pueda pagar con tarjeta en mi página." Es una de las peticiones más frecuentes y también una de las que más confusión genera, porque intervienen tres actores distintos y casi nadie explica cuál hace qué.</p>
<p>Vamos por partes, con lo que aplica específicamente en Guatemala.</p>

<h2>Los tres actores del cobro con tarjeta</h2>
<ol>
  <li><strong>Tu sitio o tienda.</strong> Donde el cliente arma el pedido y llega al momento de pagar.</li>
  <li><strong>La pasarela de pago.</strong> El servicio que recibe los datos de la tarjeta de forma segura, los valida y devuelve una respuesta. Los datos de la tarjeta nunca deberían pasar por tu servidor.</li>
  <li><strong>El banco adquirente.</strong> La entidad que te afilia al servicio, define tu comisión por transacción y deposita el dinero en tu cuenta.</li>
</ol>
<p>Necesitás los tres. Un proveedor web puede resolver el primero y conectar el segundo, pero el tercero lo contrata tu empresa directamente. Nadie puede afiliarte por vos.</p>

<h2>Qué opciones hay en Guatemala</h2>

<h3>Visanet Epay</h3>
<p>Es la pasarela más usada en el país para comercio electrónico y la que integramos por defecto. Se conecta con las tiendas más comunes, procesa Visa y Mastercard en quetzales y funciona con la afiliación que gestionás a través de tu banco. Es la opción más previsible: los bancos la conocen, los ejecutivos saben qué es y los tiempos de trámite son razonables.</p>

<h3>Pasarelas de bancos locales</h3>
<p>Varios bancos guatemaltecos ofrecen su propia solución de comercio electrónico a clientes empresariales. Si ya tenés cuenta y buena relación con tu banco, vale la pena preguntar: a veces la comisión que negociás como cliente conocido es mejor que la estándar.</p>

<h3>Plataformas de cobro en línea de origen local</h3>
<p>En los últimos años surgieron opciones guatemaltecas pensadas para cobrar en línea sin el trámite tradicional de afiliación, con enlaces de pago y suscripciones. Suelen tener comisiones más altas por transacción, pero se activan mucho más rápido y sirven bien para empezar o para cobrar servicios recurrentes. Revisá condiciones vigentes antes de decidir, porque este mercado se mueve.</p>

<h3>PayPal</h3>
<p>Funciona para recibir pagos, sobre todo del extranjero. La limitación histórica en Guatemala está en el retiro de fondos hacia cuentas locales, que no siempre es directo ni inmediato. Es un buen complemento si vendés a clientes fuera del país, no un reemplazo de la pasarela local.</p>

<h3>Lo que no está disponible</h3>
<p>Conviene decirlo claro para ahorrarte tiempo: Stripe no opera en Guatemala, y Shopify Payments tampoco. Si leíste una guía que recomienda cualquiera de los dos, estaba escrita para otro país. Es una de las razones por las que muchas tiendas guatemaltecas terminan en WooCommerce, como explicamos en <a href="/blog/woocommerce-vs-shopify-guatemala/">esta comparación</a>.</p>

<h2>Cómo es el trámite de afiliación</h2>
<p>El banco va a pedirte, en términos generales:</p>
<ul>
  <li>Documentación legal de la empresa: patente de comercio, escritura de constitución y representación legal.</li>
  <li>Registro tributario vigente ante la SAT.</li>
  <li>Cuenta bancaria empresarial en la misma entidad.</li>
  <li>La dirección de tu sitio, ya funcionando, con información visible sobre productos, precios, políticas de envío, política de devoluciones y datos de contacto.</li>
  <li>Estimación de tu volumen mensual y ticket promedio.</li>
</ul>
<p>Ese punto del sitio funcionando es importante: el banco revisa tu página antes de aprobar. Si tu tienda no tiene política de devoluciones publicada ni datos de contacto claros, la solicitud se atrasa. Cuando montamos una tienda dejamos esas páginas listas justamente para que el trámite no se trabe ahí.</p>
<p>Los tiempos varían bastante entre bancos. Planificá semanas, no días, y no anuncies el cobro con tarjeta hasta tenerlo aprobado y probado.</p>

<h2>Las comisiones: qué esperar</h2>
<p>Cada banco negocia sus tarifas, así que no existe un número único. Lo que sí es constante es la estructura:</p>
<ul>
  <li>Un <strong>porcentaje por transacción</strong>, que en comercio electrónico suele ser mayor que en un datáfono físico, porque el riesgo de contracargo es más alto.</li>
  <li>A veces un <strong>monto fijo</strong> por operación.</li>
  <li>Posiblemente una <strong>renta mensual</strong> del servicio de pasarela.</li>
  <li>El <strong>plazo de liquidación</strong>: cuántos días tarda el dinero en llegar a tu cuenta.</li>
</ul>
<p>Pedí siempre estos cuatro datos por escrito antes de firmar, y hacé la cuenta con tu ticket promedio real. Si vendés productos de Q80 y la comisión combinada te come el 5%, hay que revisar si el precio lo aguanta.</p>

<h2>Lo que agrega el proveedor web</h2>
<p>Nuestra parte es técnica: instalar el módulo de la pasarela en tu tienda, configurar las credenciales, hacer compras de prueba en el ambiente de pruebas y luego en producción, verificar que los pedidos se registren correctamente y que los correos de confirmación salgan. En nuestro servicio eso cuesta Q750 al año, que además cubre el mantenimiento de la integración cuando la pasarela actualiza sus requisitos.</p>
<p>También configuramos las páginas que el banco exige revisar y dejamos el sitio con certificado SSL activo, que es requisito indispensable.</p>

<h2>¿Conviene activarlo desde el día uno?</h2>
<p>Normalmente no, y esta es la parte donde vamos en contra de nuestro propio interés comercial.</p>
<p>Si estás empezando a vender en línea, arrancá con transferencia bancaria con carga de comprobante y pago contra entrega. Son gratis, en Guatemala la gente las usa con toda naturalidad y te permiten medir demanda real. Cuando lleves dos o tres meses con pedidos constantes, hacé la cuenta: si el volumen y el ticket promedio justifican la comisión, activás la tarjeta. Hemos visto negocios pagando una pasarela para procesar tres pagos al mes.</p>
<p>La excepción es si vendés productos de precio alto, si tu cliente es corporativo o si vendés al extranjero. En esos casos el cobro con tarjeta sí cambia la conversión desde el inicio.</p>

<h2>Contracargos: lo que nadie te advierte</h2>
<p>Un contracargo ocurre cuando el titular de la tarjeta desconoce un cobro y el banco le devuelve el dinero. En comercio electrónico pasa más que en tienda física, porque no hay firma ni tarjeta presente.</p>
<p>Para reducir el riesgo: guardá el comprobante de entrega de cada pedido, mandá correos de confirmación con el detalle, publicá tu política de devoluciones y usá el nombre comercial correcto en el estado de cuenta, para que el cliente reconozca el cargo. Muchos contracargos no son fraude, sino gente que no recuerda dónde compró.</p>

<h2>Resumen</h2>
<p>Cobrar con tarjeta en Guatemala requiere tres piezas: la tienda, la pasarela y la afiliación bancaria. La opción más establecida es Visanet Epay; Stripe y Shopify Payments no aplican acá. El trámite toma semanas y el banco revisa tu sitio, así que conviene tenerlo completo antes de solicitar. Y salvo casos específicos, conviene empezar con transferencia y contra entrega y activar la tarjeta cuando el volumen lo justifique.</p>
<p>Si querés que revisemos tu caso o que preparemos tu sitio para la solicitud del banco, <a href="/contacto/">escribinos</a>.</p>
HTML,
];
