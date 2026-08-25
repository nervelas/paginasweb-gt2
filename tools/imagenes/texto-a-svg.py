#!/usr/bin/env python3
"""
Convierte texto a trazos SVG usando las fuentes variables del proyecto.
Se usa una sola vez para generar el logotipo; el resultado queda versionado.

Uso: python3 tools/imagenes/texto-a-svg.py <woff2> <peso> <texto> [tamaño]
"""
import sys, io
from fontTools.ttLib import TTFont
from fontTools.varLib import instancer
from fontTools.pens.svgPathPen import SVGPathPen


def text_to_path(woff2_path, weight, text, size=100, letter_spacing=0.0):
    font = TTFont(woff2_path)
    if 'fvar' in font:
        font = instancer.instantiateVariableFont(font, {'wght': weight}, inplace=False)
    upem = font['head'].unitsPerEm
    scale = size / upem
    cmap = font.getBestCmap()
    glyphset = font.getGlyphSet()
    hmtx = font['hmtx']

    parts = []
    x = 0.0
    for ch in text:
        gname = cmap.get(ord(ch))
        if gname is None:
            x += size * 0.3
            continue
        pen = SVGPathPen(glyphset)
        glyphset[gname].draw(pen)
        d = pen.getCommands()
        if d:
            parts.append((d, x))
        adv = hmtx[gname][0] * scale
        x += adv + letter_spacing

    # Se compone un único path trasladando cada glifo
    out = []
    for d, dx in parts:
        out.append(f'<g transform="translate({dx:.2f},0) scale({scale:.5f},{-scale:.5f})"><path d="{d}"/></g>')
    return ''.join(out), x


if __name__ == '__main__':
    woff2, weight, text = sys.argv[1], float(sys.argv[2]), sys.argv[3]
    size = float(sys.argv[4]) if len(sys.argv) > 4 else 100
    spacing = float(sys.argv[5]) if len(sys.argv) > 5 else 0.0
    path, width = text_to_path(woff2, weight, text, size, spacing)
    sys.stdout.write(f'<!--width:{width:.2f}-->\n{path}\n')
