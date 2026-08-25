<?php
/**
 * Renderiza una página a partir de sus secciones.
 * Cada bloque tiene su propia plantilla en app/Views/sections/.
 */
echo partial('partials/breadcrumbs', ['crumbs' => $crumbs]);

$fondos = ['white' => false];
$index  = 0;
foreach ($sections as $section) {
    $tpl = APP_PATH . '/Views/sections/' . $section['block_type'] . '.php';
    if (!is_file($tpl)) {
        continue;
    }
    echo partial('sections/' . $section['block_type'], [
        'section' => $section,
        'page'    => $page,
        'faqs'    => isset($faqs) ? $faqs : [],
        'index'   => $index,
    ]);
    $index++;
}
