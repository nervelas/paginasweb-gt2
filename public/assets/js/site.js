/* paginasweb.gt — comportamiento propio, sin dependencias. */
(function () {
  'use strict';

  var doc = document;
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------------------------------------------------- Menú en celular */
  var burger = doc.querySelector('.burger');
  var nav = doc.getElementById('nav');
  if (burger && nav) {
    var cerrar = function () {
      burger.setAttribute('aria-expanded', 'false');
      nav.classList.remove('open');
      doc.documentElement.style.overflow = '';
    };
    burger.addEventListener('click', function () {
      var abierto = burger.getAttribute('aria-expanded') === 'true';
      if (abierto) { cerrar(); return; }
      burger.setAttribute('aria-expanded', 'true');
      nav.classList.add('open');
      doc.documentElement.style.overflow = 'hidden';
    });
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) { cerrar(); }
    });
    doc.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) { cerrar(); burger.focus(); }
    });
  }

  /* ------------------------------------------- Aparición de las secciones */
  var subir = doc.querySelectorAll('.rise');
  if (subir.length) {
    if (reduce || !('IntersectionObserver' in window)) {
      for (var i = 0; i < subir.length; i++) { subir[i].classList.add('seen'); }
    } else {
      // Al terminar la aparición se marca 'listo', que fija la opacidad en 1 sin
      // transición. Así el texto nunca puede quedarse a medio camino, pase lo
      // que pase con el recorrido de la página.
      var fijar = function (el) {
        window.setTimeout(function () { el.classList.add('listo'); }, 1100);
      };
      var obs = new IntersectionObserver(function (entradas) {
        entradas.forEach(function (en) {
          if (en.isIntersecting) {
            en.target.classList.add('seen');
            fijar(en.target);
            obs.unobserve(en.target);
          }
        });
      }, { rootMargin: '0px 0px -6% 0px', threshold: 0.05 });
      for (var j = 0; j < subir.length; j++) { obs.observe(subir[j]); }
    }
  }

  /* --------------------- Vista previa del portafolio al pasar el puntero */
  var indice = doc.querySelector('[data-preview-index]');
  var fino = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  if (indice && fino && !reduce) {
    var caja = doc.createElement('div');
    caja.className = 'preview';
    caja.setAttribute('aria-hidden', 'true');
    var img = doc.createElement('img');
    img.alt = '';
    img.decoding = 'async';
    caja.appendChild(img);
    doc.body.appendChild(caja);

    var x = 0, y = 0, animando = false;
    var mover = function () {
      caja.style.transform = 'translate(' + x + 'px,' + y + 'px) translate(-50%,-50%) scale(1)';
      animando = false;
    };
    indice.addEventListener('pointermove', function (e) {
      x = e.clientX + 130;
      y = e.clientY;
      if (!animando) { animando = true; requestAnimationFrame(mover); }
    });
    var filas = indice.querySelectorAll('[data-shot]');
    for (var k = 0; k < filas.length; k++) {
      (function (fila) {
        fila.addEventListener('pointerenter', function () {
          var src = fila.getAttribute('data-shot');
          if (src && img.getAttribute('src') !== src) { img.src = src; }
          caja.classList.add('on');
        });
      })(filas[k]);
    }
    indice.addEventListener('pointerleave', function () { caja.classList.remove('on'); });
  }

  /* ---------------------- Preselección del servicio en el formulario */
  var sel = doc.getElementById('f-servicio');
  if (sel && window.URLSearchParams) {
    var quiere = new URLSearchParams(window.location.search).get('servicio');
    if (quiere) {
      for (var s = 0; s < sel.options.length; s++) {
        if (sel.options[s].value === quiere) { sel.selectedIndex = s; break; }
      }
    }
  }

  /* ------------------------------ Acordeón: al abrir uno se cierran los otros */
  var grupos = doc.querySelectorAll('[data-accordion]');
  for (var g = 0; g < grupos.length; g++) {
    (function (grupo) {
      var items = grupo.querySelectorAll('details.qa__item');
      for (var d = 0; d < items.length; d++) {
        items[d].addEventListener('toggle', function () {
          if (!this.open) { return; }
          for (var o = 0; o < items.length; o++) {
            if (items[o] !== this) { items[o].open = false; }
          }
        });
      }
    })(grupos[g]);
  }
})();
