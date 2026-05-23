/**
 * M&M EnerTech v5 — scroll-linked SVG fiber diagram.
 *
 * Single SVG path traced left-to-right. As the user scrolls past the section,
 * (a) the path is drawn (stroke-dashoffset), (b) a blue pulse dot rides along
 * the path via getPointAtLength(), and (c) the active station gets highlighted
 * and the matching caption fades in.
 *
 * Reduced-motion users: skip all of the above; CSS handles the static fallback.
 */
(function () {
  'use strict';

  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    return;
  }

  document.addEventListener('DOMContentLoaded', function () {
    const stage = document.querySelector('[data-fiber-stage]');
    if (!stage) return;
    const drawPath = stage.querySelector('[data-fiber-draw]');
    const pulse = stage.querySelector('[data-fiber-pulse]');
    const stations = Array.from(stage.querySelectorAll('.fiber-station'));
    const captions = Array.from(stage.querySelectorAll('.fiber-caption'));
    if (!drawPath || !pulse || stations.length === 0) return;

    const totalLen = drawPath.getTotalLength();
    drawPath.style.setProperty('--path-len', totalLen);
    drawPath.style.strokeDasharray = totalLen;
    drawPath.style.strokeDashoffset = totalLen;

    stations.forEach(function (g) {
      const t = parseFloat(g.dataset.stationT || '0');
      const p = drawPath.getPointAtLength(totalLen * t);
      g.setAttribute('transform', 'translate(' + p.x + ',' + p.y + ')');
    });

    let ticking = false;
    function update() {
      ticking = false;
      const rect = stage.getBoundingClientRect();
      const vh = window.innerHeight;
      const total = rect.height + vh;
      let progress = (vh - rect.top) / total;
      progress = Math.max(0, Math.min(1, progress));

      const t = Math.max(0, Math.min(1, (progress - 0.2) / 0.6));

      drawPath.style.strokeDashoffset = totalLen * (1 - t);

      const point = drawPath.getPointAtLength(totalLen * t);
      pulse.setAttribute('cx', point.x);
      pulse.setAttribute('cy', point.y);
      pulse.style.opacity = t > 0.001 && t < 0.999 ? 1 : 0;

      let activeIdx = 0;
      stations.forEach(function (g, i) {
        const st = parseFloat(g.dataset.stationT || '0');
        g.classList.remove('active', 'passed');
        if (t >= st - 0.04 && t <= st + 0.08) {
          g.classList.add('active');
          activeIdx = i;
        } else if (t > st) {
          g.classList.add('passed');
        }
      });
      if (t >= 0.95) activeIdx = stations.length - 1;
      captions.forEach(function (c, i) {
        c.classList.toggle('active', i === activeIdx);
      });
    }

    function onScroll() {
      if (!ticking) {
        window.requestAnimationFrame(update);
        ticking = true;
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', function () {
      const len = drawPath.getTotalLength();
      drawPath.style.strokeDasharray = len;
      stations.forEach(function (g) {
        const t = parseFloat(g.dataset.stationT || '0');
        const p = drawPath.getPointAtLength(len * t);
        g.setAttribute('transform', 'translate(' + p.x + ',' + p.y + ')');
      });
      update();
    });

    update();
  });
})();
