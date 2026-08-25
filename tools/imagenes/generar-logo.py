#!/usr/bin/env python3
"""
Identidad de paginasweb.gt: logotipo en trazos (sin depender de tipografías
en el navegador), versión clara y oscura, marca cuadrada y logotipo grande
para el pie de página.
"""
import os, sys
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
from importlib import import_module
t2s = import_module('texto-a-svg')

ROOT = os.path.abspath(os.path.join(os.path.dirname(__file__), '..', '..'))
GEIST = os.path.join(ROOT, 'public/assets/fonts/geist-wght.woff2')
SERIF = os.path.join(ROOT, 'public/assets/fonts/instrument-serif-400.woff2')
OUT = os.path.join(ROOT, 'public/assets/img')

OBSIDIAN = '#0A0C0F'
BONE     = '#F3F0E9'
QUETZAL  = '#11E39A'
QUETZAL_INK = '#04684E'

ALTO = 26.0          # altura de referencia del logotipo
TRACK = -0.9         # ajuste óptico entre letras


def wordmark(color_texto, color_punto):
    """Logotipo horizontal: 'paginasweb' + '.gt' en el color de señal."""
    p1, w1 = t2s.text_to_path(GEIST, 600, 'paginasweb', ALTO, TRACK)
    p2, w2 = t2s.text_to_path(GEIST, 600, '.gt', ALTO, TRACK)
    ancho = w1 + w2
    alto = 26.0
    base = 19.4       # línea de base dentro del lienzo
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {ancho:.1f} {alto}" '
        f'width="{ancho:.1f}" height="{alto}" role="img" aria-label="paginasweb.gt">'
        f'<title>paginasweb.gt</title>'
        f'<g transform="translate(0,{base})" fill="{color_texto}">{p1}</g>'
        f'<g transform="translate({w1:.2f},{base})" fill="{color_punto}">{p2}</g>'
        f'</svg>\n'
    )


def marca_cuadrada(fondo, letra, tam=64, radio=0):
    """Marca compacta para favicon e iconos de aplicación."""
    p, w = t2s.text_to_path(GEIST, 600, 'p.', tam * 0.56, -0.6)
    x = (tam - w) / 2
    y = tam * 0.5 + tam * 0.2
    r = f' rx="{radio}"' if radio else ''
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {tam} {tam}" '
        f'width="{tam}" height="{tam}" role="img" aria-label="paginasweb.gt">'
        f'<title>paginasweb.gt</title>'
        f'<rect width="{tam}" height="{tam}"{r} fill="{fondo}"/>'
        f'<g transform="translate({x:.2f},{y:.2f})" fill="{letra}">{p}</g>'
        f'</svg>\n'
    )


def logotipo_grande():
    """Logotipo enorme del pie, en la serif editorial, para usar con currentColor."""
    p, w = t2s.text_to_path(SERIF, 400, 'paginasweb.gt', 200, -3.2)
    alto = 200.0
    base = 152.0
    return (
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {w:.1f} {alto:.0f}" '
        f'width="{w:.1f}" height="{alto:.0f}" aria-hidden="true" focusable="false">'
        f'<g transform="translate(0,{base})" fill="currentColor">{p}</g>'
        f'</svg>\n'
    )


os.makedirs(os.path.join(OUT, 'icons'), exist_ok=True)

open(os.path.join(OUT, 'marca.svg'), 'w').write(wordmark(OBSIDIAN, QUETZAL_INK))
open(os.path.join(OUT, 'marca-blanca.svg'), 'w').write(wordmark(BONE, QUETZAL))
open(os.path.join(OUT, 'marca-grande.svg'), 'w').write(logotipo_grande())
open(os.path.join(ROOT, 'public/favicon.svg'), 'w').write(marca_cuadrada(QUETZAL, OBSIDIAN))
open(os.path.join(OUT, 'icons/marca-cuadrada.svg'), 'w').write(marca_cuadrada(QUETZAL, OBSIDIAN, 512))

print('Identidad generada en', OUT)
