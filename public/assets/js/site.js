/* paginasweb.gt — JavaScript propio, sin dependencias. */
(function () {
  'use strict';

  var doc = document;

  /* ------------------------------------------------- Menú en celular */
  var toggle = doc.querySelector('.nav-toggle');
  var nav = doc.getElementById('nav-principal');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
      nav.classList.toggle('is-open', !open);
      doc.body.style.overflow = open ? '' : 'hidden';
    });
    nav.addEventListener('click', function (e) {
      if (e.target.tagName === 'A' && nav.classList.contains('is-open')) {
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove('is-open');
        doc.body.style.overflow = '';
      }
    });
    doc.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        toggle.setAttribute('aria-expanded', 'false');
        nav.classList.remove('is-open');
        doc.body.style.overflow = '';
        toggle.focus();
      }
    });
  }

  /* ------------------------------------- Sombra del encabezado al hacer scroll */
  var header = doc.querySelector('.site-header');
  if (header) {
    var setStuck = function () {
      header.classList.toggle('is-stuck', window.scrollY > 8);
    };
    setStuck();
    window.addEventListener('scroll', setStuck, { passive: true });
  }

  /* ------------------------------------------- Aparición suave de secciones */
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var reveals = doc.querySelectorAll('.reveal');
  if (reveals.length) {
    if (reduce || !('IntersectionObserver' in window)) {
      for (var i = 0; i < reveals.length; i++) {
        reveals[i].classList.add('is-visible');
      }
    } else {
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      }, { rootMargin: '0px 0px -8% 0px', threshold: 0.06 });
      for (var j = 0; j < reveals.length; j++) {
        observer.observe(reveals[j]);
      }
    }
  }

  /* --------------------- Preselección del servicio en el formulario */
  var select = doc.getElementById('campo-servicio');
  if (select) {
    var params = new URLSearchParams(window.location.search);
    var wanted = params.get('servicio');
    if (wanted) {
      for (var k = 0; k < select.options.length; k++) {
        if (select.options[k].value === wanted) {
          select.selectedIndex = k;
          break;
        }
      }
    }
  }

  /* ------------------------------ Acordeón: cerrar los demás al abrir uno */
  var groups = doc.querySelectorAll('[data-faq-group]');
  for (var g = 0; g < groups.length; g++) {
    (function (group) {
      var items = group.querySelectorAll('details.faq-item');
      for (var d = 0; d < items.length; d++) {
        items[d].addEventListener('toggle', function () {
          if (!this.open) { return; }
          for (var o = 0; o < items.length; o++) {
            if (items[o] !== this) { items[o].open = false; }
          }
        });
      }
    })(groups[g]);
  }
})();
