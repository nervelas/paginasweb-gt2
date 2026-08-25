<?php
return [
    'slug'     => 'politica-de-privacidad',
    'name'     => 'Política de privacidad',
    'template' => 'legal',
    'h1'       => 'Política de privacidad',
    'meta_title'       => 'Política de Privacidad | paginasweb.gt',
    'meta_description' => 'Qué datos recolectamos en este sitio, para qué los usamos, cuánto tiempo los guardamos y cómo podés pedir que los eliminemos.',
    'sort_order' => 21,
    'in_footer'  => true,
    'sections' => [
        [
            'block_type' => 'page_hero',
            'eyebrow'    => 'Información legal',
            'heading'    => 'Política de privacidad',
            'subheading' => 'Qué datos recogemos en este sitio, para qué los usamos y cómo podés pedir que los eliminemos.',
        ],
        [
            'block_type' => 'legal_text',
            'body' => <<<'HTML'
<p class="lead">Esta política explica qué información recolecta paginasweb.gt, marca comercial de Servicom, cuando visitás este sitio o nos escribís, para qué la usamos y qué podés pedirnos respecto de ella.</p>

<h2>Quién trata tus datos</h2>
<p>El responsable del tratamiento es Servicom, con operaciones en la ciudad de Guatemala. Para cualquier consulta sobre esta política podés escribirnos al correo de contacto publicado en la página de <a href="/contacto/">contacto</a>.</p>

<h2>Qué datos recolectamos</h2>
<p><strong>Datos que nos das voluntariamente.</strong> Cuando llenás el formulario de cotización nos compartís tu nombre, tu correo electrónico, tu teléfono, el servicio que te interesa y el mensaje que escribís. Si nos contactás por WhatsApp o por teléfono, quedan los datos propios de esa conversación.</p>
<p><strong>Datos técnicos de la visita.</strong> Como cualquier sitio, nuestro servidor registra la dirección IP, la fecha y hora de la visita, el navegador y las páginas consultadas. Esa información se usa para seguridad y para diagnosticar problemas.</p>
<p><strong>Estadísticas de uso.</strong> Si están activadas las herramientas de analítica, se recopilan datos agregados sobre cómo se navega el sitio: páginas más vistas, tiempo de permanencia, tipo de dispositivo y país de origen. No usamos esa información para identificarte personalmente.</p>

<h2>Para qué usamos la información</h2>
<ul>
  <li>Responder tu consulta y prepararte una propuesta.</li>
  <li>Prestar y administrar el servicio si llegás a contratarnos.</li>
  <li>Mantener la seguridad del sitio y prevenir abusos del formulario.</li>
  <li>Entender cómo se usa el sitio para mejorarlo.</li>
</ul>
<p>No vendemos, alquilamos ni cedemos tus datos a terceros con fines comerciales, y no te vamos a suscribir a un boletín por haber llenado un formulario de cotización.</p>

<h2>Cookies</h2>
<p>Este sitio usa una cookie técnica de sesión, necesaria para el funcionamiento de los formularios y del panel de administración. Si están activadas las herramientas de analítica o de publicidad, esas herramientas pueden instalar sus propias cookies. Podés bloquear o eliminar cookies desde la configuración de tu navegador; el sitio sigue funcionando, aunque el envío de formularios podría verse afectado.</p>

<h2>Con quién compartimos datos</h2>
<p>Solo con proveedores necesarios para operar: el servicio de alojamiento donde vive este sitio y el servicio de correo por el que nos llegan tus mensajes. Si usamos herramientas de analítica de terceros, esos proveedores tratan datos técnicos conforme a sus propias políticas. También podríamos compartir información si una autoridad competente lo requiere legalmente.</p>

<h2>Cuánto tiempo guardamos la información</h2>
<p>Los mensajes recibidos por el formulario se conservan mientras sean útiles para la relación comercial. Si nos pedís que eliminemos tu consulta, lo hacemos. Los registros técnicos del servidor se conservan por períodos cortos, según la política del proveedor de alojamiento. La información de clientes activos se conserva mientras dure la relación y el tiempo adicional que exijan las obligaciones contables y fiscales.</p>

<h2>Tus derechos</h2>
<p>Podés pedirnos que te digamos qué datos tuyos tenemos, que los corrijamos si están equivocados o que los eliminemos. Escribinos desde el correo con el que nos contactaste y atendemos la solicitud en un plazo razonable.</p>

<h2>Seguridad</h2>
<p>El sitio opera bajo conexión cifrada (HTTPS), los accesos administrativos están protegidos con contraseñas cifradas y límite de intentos de acceso, y las consultas a la base de datos usan sentencias preparadas. Ningún sistema es infalible, pero aplicamos las medidas razonables para proteger la información.</p>

<h2>Menores de edad</h2>
<p>Este sitio está dirigido a personas que contratan servicios para su negocio. No solicitamos de forma consciente datos de menores de edad.</p>

<h2>Cambios en esta política</h2>
<p>Si actualizamos esta política, publicamos la nueva versión en esta misma dirección con su fecha de última actualización.</p>
HTML,
        ],
    ],
];
