/* Nulesmana gallery autoplay: additive layer for the existing coverflow.
   Leaves the existing slide transforms, buttons, swipe and scroll logic untouched. */
(() => {
  'use strict';

  function init() {
    document.querySelectorAll('[data-coverflow]').forEach((carousel) => {
      if (carousel.dataset.nuAutoplayReady === '1') return;

      const stage = carousel.querySelector('.coverflow-stage');
      const slides = carousel.querySelectorAll('.coverflow-slide');
      const next = carousel.querySelector('.coverflow-next');
      if (!stage || !next || slides.length < 2) return;

      carousel.dataset.nuAutoplayReady = '1';
      const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
      const requestedInterval = Number(carousel.dataset.autoplayInterval);
      const delay = Number.isFinite(requestedInterval) && requestedInterval >= 1500
        ? requestedInterval : 4300;
      let visible = false;
      let hovered = false;
      let interacting = false;
      let timer = null;
      let resumeTimer = null;

      const allowed = () => visible && !hovered && !interacting && !document.hidden && !motion.matches;
      const stop = () => {
        if (timer !== null) clearInterval(timer);
        timer = null;
      };
      const start = () => {
        stop();
        if (!allowed()) return;
        timer = setInterval(() => {
          if (allowed()) next.click();
        }, delay);
      };
      const pauseForInteraction = () => {
        interacting = true;
        stop();
        if (resumeTimer !== null) clearTimeout(resumeTimer);
        resumeTimer = setTimeout(() => {
          interacting = false;
          start();
        }, 6500);
      };

      carousel.addEventListener('mouseenter', () => { hovered = true; stop(); });
      carousel.addEventListener('mouseleave', () => { hovered = false; start(); });
      carousel.addEventListener('focusin', () => { hovered = true; stop(); });
      carousel.addEventListener('focusout', (event) => {
        if (!carousel.contains(event.relatedTarget)) { hovered = false; start(); }
      });
      stage.addEventListener('pointerdown', pauseForInteraction, { passive: true });
      stage.addEventListener('wheel', pauseForInteraction, { passive: true });
      carousel.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') pauseForInteraction();
      });
      carousel.querySelectorAll('.coverflow-prev, .coverflow-next').forEach((button) => {
        // Programmatic autoplay uses .click(), which must not count as manual interaction.
        button.addEventListener('pointerdown', pauseForInteraction, { passive: true });
      });
      document.addEventListener('visibilitychange', start);
      if (typeof motion.addEventListener === 'function') motion.addEventListener('change', start);

      if ('IntersectionObserver' in window) {
        const watcher = new IntersectionObserver((entries) => {
          visible = entries.some((entry) => entry.isIntersecting && entry.intersectionRatio >= 0.2);
          start();
        }, { threshold: [0, 0.2, 0.5] });
        watcher.observe(carousel);
      } else {
        visible = true;
        start();
      }
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init, { once: true });
  } else {
    init();
  }
})();
