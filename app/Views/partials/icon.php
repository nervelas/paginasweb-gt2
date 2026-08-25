<?php
/**
 * Iconos SVG propios, dibujados a mano en trazo de 1.6.
 * Uso: partial('partials/icon', ['name' => 'cart', 'size' => 24])
 */
$name = isset($name) ? $name : 'check';
$size = isset($size) ? $size : 24;
$paths = [
    'browser'  => '<rect x="2.5" y="4" width="19" height="16" rx="2.5"/><path d="M2.5 8.5h19M5.6 6.3h.01M8 6.3h.01"/>',
    'cart'     => '<path d="M2.5 3.5h2.2l2.3 11h10.4l2.1-8H6.2"/><circle cx="9.5" cy="19" r="1.4"/><circle cx="17" cy="19" r="1.4"/>',
    'mail'     => '<rect x="2.5" y="4.5" width="19" height="15" rx="2.5"/><path d="M3.4 6.4L12 12.6l8.6-6.2"/>',
    'phone'    => '<rect x="6.5" y="2.5" width="11" height="19" rx="2.6"/><path d="M10.6 18.6h2.8"/>',
    'bolt'     => '<path d="M13.4 2.5L4.6 13.4h6l-1 8.1 8.8-10.9h-6z"/>',
    'shield'   => '<path d="M12 2.6l7.5 3v5.6c0 4.4-3 8.2-7.5 10.2-4.5-2-7.5-5.8-7.5-10.2V5.6z"/><path d="M8.8 12l2.2 2.2 4.2-4.4"/>',
    'search'   => '<circle cx="10.8" cy="10.8" r="6.6"/><path d="M15.6 15.6l5 5"/>',
    'chat'     => '<path d="M20.5 12.4c0 4-3.8 7.2-8.5 7.2-1.1 0-2.2-.2-3.2-.5l-5.3 1.7 1.7-4.4c-1-1.2-1.7-2.6-1.7-4.2 0-4 3.8-7.2 8.5-7.2s8.5 3.2 8.5 7.4z"/>',
    'edit'     => '<path d="M4 20h4.2L19 9.2a2.4 2.4 0 0 0 0-3.4l-.8-.8a2.4 2.4 0 0 0-3.4 0L4 15.8z"/><path d="M13.6 6.6l3.8 3.8"/>',
    'image'    => '<rect x="2.6" y="4.5" width="18.8" height="15" rx="2.4"/><circle cx="8.4" cy="9.6" r="1.7"/><path d="M3.4 17.2l5-4.6 4 3.4 3.4-2.8 4.8 4"/>',
    'layout'   => '<rect x="2.6" y="3.6" width="18.8" height="16.8" rx="2.4"/><path d="M2.6 9h18.8M9.4 9v11.4"/>',
    'chart'    => '<path d="M3.4 20.4h17.2"/><path d="M6.6 20.4v-6.8M11.2 20.4V6.4M15.8 20.4v-9.6M20 20.4V9"/>',
    'truck'    => '<path d="M2.6 6.4h11v10.2h-11z"/><path d="M13.6 9.6h4l3.2 3.4v3.6h-7.2z"/><circle cx="6.6" cy="18.6" r="1.7"/><circle cx="16.8" cy="18.6" r="1.7"/>',
    'card'     => '<rect x="2.4" y="5" width="19.2" height="14" rx="2.4"/><path d="M2.4 9.6h19.2M6 14.6h3.4"/>',
    'box'      => '<path d="M12 2.8l8.4 4.4v9.6L12 21.2 3.6 16.8V7.2z"/><path d="M3.8 7.3L12 11.6l8.2-4.3M12 11.6v9.4"/>',
    'file'     => '<path d="M13.4 2.6H6.8a2 2 0 0 0-2 2v14.8a2 2 0 0 0 2 2h10.4a2 2 0 0 0 2-2V8.4z"/><path d="M13.4 2.6v5.8h5.8M8.6 13h6.8M8.6 16.6h4.6"/>',
    'check'    => '<path d="M4.6 12.4l4.6 4.6L19.4 6.8"/>',
    'arrow'    => '<path d="M4.5 12h15M13.4 5.8L19.6 12l-6.2 6.2"/>',
    'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 6.8V12l3.4 2"/>',
    'pin'      => '<path d="M12 21.4s7-5.8 7-11a7 7 0 1 0-14 0c0 5.2 7 11 7 11z"/><circle cx="12" cy="10.2" r="2.6"/>',
    'external' => '<path d="M14 4.6h5.4V10"/><path d="M19.4 4.6L11 13M17 13.6v5a1.8 1.8 0 0 1-1.8 1.8H5.4a1.8 1.8 0 0 1-1.8-1.8V8.8A1.8 1.8 0 0 1 5.4 7h5"/>',
    'whatsapp' => '<path d="M17.5 14.4c-.3-.2-1.7-.9-2-1-.3-.1-.5-.1-.7.1s-.7 1-.9 1.2c-.2.2-.3.2-.6.1-1.7-.9-2.9-1.6-4-3.5-.3-.5.3-.5.9-1.6.1-.2 0-.4 0-.5s-.7-1.6-.9-2.2c-.2-.5-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.3 5.2 4.6 1.9.8 2.7.9 3.7.7.6-.1 1.7-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.3z" fill="currentColor" stroke="none"/><path d="M12 2.8a9.1 9.1 0 0 0-7.8 13.8L2.8 21.2l4.7-1.3A9.1 9.1 0 1 0 12 2.8z"/>',
    'facebook' => '<path d="M13.6 21v-8.2h2.8l.4-3.2h-3.2V7.5c0-.9.3-1.6 1.6-1.6h1.7V3.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.3H7.4v3.2h2.8V21z" fill="currentColor" stroke="none"/>',
    'instagram'=> '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1" fill="currentColor" stroke="none"/>',
    'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M7.4 10.2v7M7.4 7.1v.01M11.4 17v-7M11.4 12.8c0-1.4 1-2.2 2.2-2.2s2.2.8 2.2 2.4V17"/>',
    'youtube'  => '<rect x="2.4" y="5.6" width="19.2" height="12.8" rx="3.6"/><path d="M10.4 9.6l4.8 2.4-4.8 2.4z"/>',
];
$path = isset($paths[$name]) ? $paths[$name] : $paths['check'];
?>
<svg viewBox="0 0 24 24" width="<?php echo (int) $size; ?>" height="<?php echo (int) $size; ?>" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?php echo $path; ?></svg>
