/*
 * Nulesmana TechText Lite v4
 * CSS-composited, per-letter interaction. No React, no Canvas, no perpetual RAF.
 * Scoped to .nu-tech-line on the public landing page.
 */
(() => {
  'use strict';
  if (window.__nulesmanaTechTextLiteLoaded) return;
  window.__nulesmanaTechTextLiteLoaded = true;

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const coarsePointer = window.matchMedia('(pointer: coarse)');
  const kickTimers = new WeakMap();

  function kick(letter) {
    if (reduceMotion.matches) return;
    letter.classList.remove('nu-lite-kick');
    void letter.offsetWidth; // Restart one-shot animation on a repeat click.
    letter.classList.add('nu-lite-kick');
    const old = kickTimers.get(letter);
    if (old) clearTimeout(old);
    kickTimers.set(letter, setTimeout(() => letter.classList.remove('nu-lite-kick'), 620));
  }

  function init(line) {
    if (line.dataset.ready === 'true') return;
    const source = line.getAttribute('data-nu-tech-text');
    if (!source) return;

    const word = document.createElement('span');
    word.className = 'nu-lite-word';
    word.setAttribute('aria-hidden', 'true');
    const fragment = document.createDocumentFragment();
    let index = 0;

    for (const char of Array.from(source)) {
      if (/\s/.test(char)) {
        fragment.appendChild(document.createTextNode(char));
      } else {
        const letter = document.createElement('span');
        letter.className = 'nu-lite-letter';
        letter.textContent = char;
        letter.style.setProperty('--nu-delay', `${Math.min(index * 28, 420)}ms`);
        fragment.appendChild(letter);
      }
      index++;
    }
    word.appendChild(fragment);
    line.appendChild(word);
    // Switch from the accessible static fallback only after the new letters exist.
    line.dataset.ready = 'true';

    let dragging = null;

    word.addEventListener('pointerdown', (event) => {
      if (coarsePointer.matches || event.button !== 0 || reduceMotion.matches) return;
      const letter = event.target.closest('.nu-lite-letter');
      if (!letter || !word.contains(letter)) return;
      dragging = {
        letter,
        id: event.pointerId,
        startX: event.clientX,
        startY: event.clientY,
        moved: false
      };
      letter.classList.add('nu-lite-grabbing');
      try { letter.setPointerCapture(event.pointerId); } catch (_) { /* capture may be unavailable */ }
    });

    word.addEventListener('pointermove', (event) => {
      if (!dragging || dragging.id !== event.pointerId) return;
      const dx = Math.max(-80, Math.min(80, event.clientX - dragging.startX));
      const dy = Math.max(-65, Math.min(65, event.clientY - dragging.startY));
      if (Math.abs(dx) > 5 || Math.abs(dy) > 5) dragging.moved = true;
      const letter = dragging.letter;
      letter.style.setProperty('--nu-x', `${dx}px`);
      letter.style.setProperty('--nu-y', `${dy}px`);
    });

    function release(event) {
      if (!dragging || dragging.id !== event.pointerId) return;
      const { letter, moved } = dragging;
      dragging = null;
      try { letter.releasePointerCapture(event.pointerId); } catch (_) { /* no capture */ }
      letter.classList.remove('nu-lite-grabbing');
      letter.style.removeProperty('--nu-x');
      letter.style.removeProperty('--nu-y');
      if (event.type === 'pointerup' && !moved) kick(letter);
    }
    word.addEventListener('pointerup', release);
    word.addEventListener('pointercancel', release);
    word.addEventListener('lostpointercapture', (event) => {
      if (dragging && dragging.id === event.pointerId) release(event);
    });
  }

  function start() {
    document.querySelectorAll('.nu-tech-line[data-nu-tech-text]').forEach(init);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start, { once: true });
  } else start();
})();
