<?php
/**
 * Compone una página a partir de sus secciones.
 * El lienzo (oscuro / hueso) se asigna por tipo de bloque para que el ritmo
 * de la página alterne solo; cuando dos secciones seguidas comparten lienzo
 * se dibuja una regla capilar entre ellas.
 */
$lienzos = [
    'hero'            => 'propio',
    'page_hero'       => 'propio',
    'cta'             => 'propio',
    'stats'           => 'dark',
    'features'        => 'dark',
    'portfolio_grid'  => 'dark',
    'posts_grid'      => 'dark',
    'process'         => 'bone-2',
    'comparison'      => 'bone-2',
    'faq'             => 'bone-2',
];

echo partial('partials/crumbs', ['crumbs' => $crumbs]);

$previo  = null;
$numero  = 0;

foreach ($sections as $seccion) {
    $tipo = $seccion['block_type'];
    if (!is_file(APP_PATH . '/Views/sections/' . $tipo . '.php')) {
        continue;
    }
    $lienzo = isset($lienzos[$tipo]) ? $lienzos[$tipo] : 'bone';

    // Numeración visible solo en los bloques que llevan encabezado propio
    if (!in_array($tipo, ['hero', 'page_hero', 'cta', 'stats', 'legal_text'], true)) {
        $numero++;
    }

    echo partial('sections/' . $tipo, [
        'section' => $seccion,
        'page'    => $page,
        'faqs'    => isset($faqs) ? $faqs : [],
        'lienzo'  => $lienzo,
        'regla'   => ($lienzo !== 'propio' && $lienzo === $previo),
        'n'       => str_pad((string) $numero, 2, '0', STR_PAD_LEFT),
    ]);

    $previo = $lienzo;
}
