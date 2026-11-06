/* Nulesmana V6 interactive editorial heading.
   No React or Canvas. One entrance animation + occasional, paused-on-hover sweep.
   The source HTML stays readable if JS fails. */
(() => {
  'use strict';
  if (window.__nuTechTextV6) return;
  window.__nuTechTextV6 = true;

  function init() {
    const hero = document.getElementById('nu-home-hero');
    if (!hero) return;
    const title = hero.querySelector('.nu-tech-hero-title');
    if (!title) return;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
    const lines = [...title.querySelectorAll('.nu-tech-line[data-nu-tech-text]')];
    const allLetters = [];
    let sweepTimeout = 0;
    let sweepStep = 0;
    let swept = null;
    let visible = true;
    let pointerInTitle = false;
    let dragging = null;
    let dragMoved = false;

    lines.forEach((line, lineIndex) => {
      if (line.dataset.ttReady === '1') return;
      const text = line.getAttribute('data-nu-tech-text') || '';
      const word = document.createElement('span');
      word.className = 'nu-tt-word';
      word.setAttribute('aria-hidden', 'true');
      const fragment = document.createDocumentFragment();
      let count = 0;
      for (const ch of Array.from(text)) {
        if (/\s/.test(ch)) {
          fragment.appendChild(document.createTextNode(ch));
        } else {
          const span = document.createElement('span');
          span.className = 'nu-tt-letter';
          span.textContent = ch;
          span.style.setProperty('--tt-delay', `${Math.min((count + lineIndex * 3) * 43, 680)}ms`);
          fragment.appendChild(span);
          allLetters.push(span);
        }
        count++;
      }
      word.appendChild(fragment);
      line.appendChild(word);
      if (!reduceMotion.matches) word.classList.add('is-introducing');
      line.dataset.ttReady = '1';
      window.setTimeout(() => word.classList.remove('is-introducing'), 1500);
    });

    function fit() {
      lines.forEach(line => {
        line.style.fontSize = '';
        const rendered = line.querySelector('.nu-tt-word') || line.querySelector('.nu-tech-fallback');
        if (!rendered) return;
        const available = line.clientWidth - 6;
        if (available <= 0) return;
        const actual = rendered.getBoundingClientRect().width;
        if (actual > available) {
          const base = parseFloat(getComputedStyle(line).fontSize);
          line.style.fontSize = `${Math.max(27, base * available / actual * .99).toFixed(2)}px`;
        }
      });
    }

    function unsweep() {
      if (swept) swept.classList.remove('is-swept');
      swept = null;
    }
    function pauseSweep() {
      clearTimeout(sweepTimeout);
      clearInterval(sweepStep);
      sweepTimeout = sweepStep = 0;
      unsweep();
    }
    function scheduleSweep(delay = 4200) {
      pauseSweep();
      if (reduceMotion.matches || !visible || document.hidden || pointerInTitle || allLetters.length === 0) return;
      sweepTimeout = window.setTimeout(() => {
        if (document.hidden || pointerInTitle || !visible) return;
        let i = 0;
        sweepStep = window.setInterval(() => {
          unsweep();
          if (i >= allLetters.length) {
            clearInterval(sweepStep);
            sweepStep = 0;
            scheduleSweep(8000);
            return;
          }
          swept = allLetters[i++];
          swept.classList.add('is-swept');
        }, 115);
      }, delay);
    }

    title.addEventListener('pointerenter', () => { pointerInTitle = true; pauseSweep(); });
    title.addEventListener('pointerleave', () => {
      pointerInTitle = false;
      if (dragging) releaseDrag();
      scheduleSweep(2200);
    });
    title.addEventListener('pointerover', e => {
      const letter = e.target.closest?.('.nu-tt-letter');
      if (letter) letter.classList.add('is-selected');
    });
    title.addEventListener('pointerout', e => {
      const letter = e.target.closest?.('.nu-tt-letter');
      if (letter && !letter.classList.contains('is-dragged')) letter.classList.remove('is-selected');
    });

    function kick(letter) {
      if (reduceMotion.matches) return;
      letter.classList.remove('is-kicked');
      // One reflow on a *click*, not on every animation frame.
      void letter.offsetWidth;
      letter.classList.add('is-kicked');
      setTimeout(() => letter.classList.remove('is-kicked'), 560);
    }
    function releaseDrag() {
      if (!dragging) return;
      const letter = dragging.letter;
      letter.classList.remove('is-dragged', 'is-selected');
      letter.style.removeProperty('--tt-x');
      letter.style.removeProperty('--tt-y');
      try { letter.releasePointerCapture(dragging.id); } catch (_) {}
      dragging = null;
    }
    title.addEventListener('pointerdown', e => {
      if (!finePointer.matches || reduceMotion.matches || e.button !== 0) return;
      const letter = e.target.closest?.('.nu-tt-letter');
      if (!letter || !title.contains(letter)) return;
      dragging = { letter, id: e.pointerId, x: e.clientX, y: e.clientY };
      dragMoved = false;
      letter.classList.add('is-dragged');
      try { letter.setPointerCapture(e.pointerId); } catch (_) {}
    });
    title.addEventListener('pointermove', e => {
      if (!dragging || e.pointerId !== dragging.id) return;
      const dx = Math.max(-65, Math.min(65, e.clientX - dragging.x));
      const dy = Math.max(-50, Math.min(50, e.clientY - dragging.y));
      if (Math.abs(dx) + Math.abs(dy) > 6) dragMoved = true;
      dragging.letter.style.setProperty('--tt-x', `${dx}px`);
      dragging.letter.style.setProperty('--tt-y', `${dy}px`);
    });
    title.addEventListener('pointerup', e => {
      const letter = dragging?.letter;
      if (letter && e.pointerId === dragging.id) {
        releaseDrag();
        if (!dragMoved) kick(letter);
        return;
      }
      if (!finePointer.matches) {
        const tapped = e.target.closest?.('.nu-tt-letter');
        if (tapped) {
          tapped.classList.add('is-selected');
          setTimeout(() => tapped.classList.remove('is-selected'), 750);
        }
      }
    });
    title.addEventListener('pointercancel', releaseDrag);
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) pauseSweep(); else scheduleSweep(1600);
    });
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver(entries => {
        visible = !!entries[0]?.isIntersecting;
        if (visible) scheduleSweep(1800); else pauseSweep();
      }, { threshold: .05 });
      observer.observe(title);
    }
    if ('ResizeObserver' in window) new ResizeObserver(fit).observe(title);
    window.addEventListener('resize', fit, { passive: true });
    if (document.fonts?.ready) document.fonts.ready.then(fit, fit);
    fit();
    scheduleSweep(1800);
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init, { once: true });
  else init();
})();
