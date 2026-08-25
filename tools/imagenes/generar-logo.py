#!/usr/bin/env python3
"""
Genera el logotipo de paginasweb.gt en SVG (versión color y versión blanca)
y la marca suelta para favicon e iconos. El texto va convertido a trazos,
así se ve igual en cualquier navegador sin cargar tipografías.
"""
import os, sys
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from importlib import import_module
t2s = import_module('texto-a-svg')

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
FONT = os.path.join(ROOT, 'public/assets/fonts/manrope-latin-wght.woff2')
OUT = os.path.join(ROOT, 'public/assets/img')

JADE, JADE_DEEP, CORAL, INK, PAPER = '#12796B', '#0B5347', '#FF7A45', '#0A1F2C', '#F7F3EC'

SIZE = 26.0
SPACING = -0.6
MARK_W = 44.0
GAP = 13.0
BASELINE = 30.5


def marca(idc, color_fondo, color_pagina, color_acento, borde=None):
    """Cuadrado redondeado con dos hojas superpuestas y una barra de acento."""
    borde_attr = f' stroke="{borde}" stroke-width="1.5"' if borde else ''
    return f'''<g id="{idc}">
    <rect x="0" y="0" width="44" height="44" rx="13" fill="{color_fondo}"{borde_attr}/>
    <rect x="9.5" y="10" width="19" height="24" rx="3.5" fill="{color_pagina}" opacity=".42"/>
    <rect x="15.5" y="14" width="19" height="24" rx="3.5" fill="{color_pagina}"/>
    <rect x="15.5" y="14" width="19" height="5.6" rx="2.8" fill="{color_acento}"/>
    <rect x="15.5" y="16.8" width="19" height="2.8" fill="{color_acento}"/>
    <circle cx="19.2" cy="16.8" r="1.15" fill="{color_pagina}" opacity=".85"/>
    <circle cx="23" cy="16.8" r="1.15" fill="{color_pagina}" opacity=".85"/>
    <rect x="19" y="23" width="12" height="2.2" rx="1.1" fill="{color_fondo}" opacity=".55"/>
    <rect x="19" y="27.4" width="8.4" height="2.2" rx="1.1" fill="{color_fondo}" opacity=".38"/>
  </g>'''


def logo(color_texto, color_punto_gt, marca_svg, mark_w=MARK_W):
    p1, w1 = t2s.text_to_path(FONT, 800, 'paginasweb', SIZE, SPACING)
    p2, w2 = t2s.text_to_path(FONT, 800, '.gt', SIZE, SPACING)
    total_w = mark_w + GAP + w1 + w2
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {total_w:.1f} 44" width="{total_w:.1f}" height="44" role="img" aria-label="paginasweb.gt">
  <title>paginasweb.gt</title>
{marca_svg}
  <g transform="translate({mark_w + GAP:.2f},{BASELINE})" fill="{color_texto}">{p1}</g>
  <g transform="translate({mark_w + GAP + w1:.2f},{BASELINE})" fill="{color_punto_gt}">{p2}</g>
</svg>
'''


os.makedirs(OUT, exist_ok=True)
os.makedirs(os.path.join(OUT, 'icons'), exist_ok=True)

# Versión a color, para fondo claro
color = logo(INK, CORAL, marca('m', JADE, '#FFFFFF', CORAL))
open(os.path.join(OUT, 'logo-paginasweb-gt.svg'), 'w').write(color)

# Versión blanca, para el pie de página oscuro
blanco = logo('#FFFFFF', CORAL, marca('m', '#FFFFFF', JADE_DEEP, CORAL))
open(os.path.join(OUT, 'logo-paginasweb-gt-blanco.svg'), 'w').write(blanco)

# Marca suelta (favicon e iconos de aplicación)
favicon = f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44" height="44" role="img" aria-label="paginasweb.gt">
  <title>paginasweb.gt</title>
{marca('m', JADE, '#FFFFFF', CORAL)}
</svg>
'''
open(os.path.join(ROOT, 'public/favicon.svg'), 'w').write(favicon)

# Versión con margen para iconos PWA (fondo completo)
icono = f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64">
  <rect width="64" height="64" rx="14" fill="{JADE}"/>
  <g transform="translate(10,10) scale(1)">
    <rect x="9.5" y="10" width="19" height="24" rx="3.5" fill="#FFFFFF" opacity=".42"/>
    <rect x="15.5" y="14" width="19" height="24" rx="3.5" fill="#FFFFFF"/>
    <rect x="15.5" y="14" width="19" height="5.6" rx="2.8" fill="{CORAL}"/>
    <rect x="15.5" y="16.8" width="19" height="2.8" fill="{CORAL}"/>
    <circle cx="19.2" cy="16.8" r="1.15" fill="#FFFFFF" opacity=".85"/>
    <circle cx="23" cy="16.8" r="1.15" fill="#FFFFFF" opacity=".85"/>
    <rect x="19" y="23" width="12" height="2.2" rx="1.1" fill="{JADE}" opacity=".55"/>
    <rect x="19" y="27.4" width="8.4" height="2.2" rx="1.1" fill="{JADE}" opacity=".38"/>
  </g>
</svg>
'''
open(os.path.join(OUT, 'icons/marca-cuadrada.svg'), 'w').write(icono)

print('Logotipos generados en', OUT)
