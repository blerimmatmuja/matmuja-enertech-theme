/**
 * M&M Enfaser v6 — fiber process signature (front page only).
 *
 * Places 5 stations exactly on the SVG path (getPointAtLength), wires the
 * traveling light pulse to the same path via CSS offset-path, lights the path
 * when it scrolls into view, and links each caption to its station on hover.
 *
 * Stations are placed regardless of motion preference; CSS gates the draw and
 * pulse animations under prefers-reduced-motion (see style.css).
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    var path  = document.getElementById('fpath');
    var draw  = document.getElementById('fdraw');
    var frame = document.getElementById('fiber');
    var group = document.getElementById('stations');
    if (!path || !draw || !frame || !group) return;

    var NS = 'http://www.w3.org/2000/svg';
    var stationT = [0.05, 0.27, 0.5, 0.73, 0.95];

    function placeStations() {
      var len = path.getTotalLength();
      draw.style.setProperty('--len', len);
      frame.style.setProperty('--ppath', 'path("' + path.getAttribute('d') + '")');
      group.textContent = '';
      stationT.forEach(function (t, i) {
        var p = path.getPointAtLength(t * len);
        var g = document.createElementNS(NS, 'g');
        g.setAttribute('class', 'station');
        g.setAttribute('data-i', i + 1);
        var c = document.createElementNS(NS, 'circle');
        c.setAttribute('cx', p.x); c.setAttribute('cy', p.y); c.setAttribute('r', '11');
        var tx = document.createElementNS(NS, 'text');
        tx.setAttribute('x', p.x); tx.setAttribute('y', p.y - 26); tx.setAttribute('text-anchor', 'middle');
        tx.textContent = '0' + (i + 1);
        g.appendChild(c); g.appendChild(tx); group.appendChild(g);
      });
    }

    placeStations();
    window.addEventListener('resize', placeStations, { passive: true });

    // Light the path when it enters the viewport.
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { frame.classList.add('lit'); io.disconnect(); }
      });
    }, { threshold: 0.3 });
    io.observe(frame);

    // Link captions <-> stations on hover/focus.
    function hot(i, on) {
      var cap = document.querySelector('.cap[data-i="' + i + '"]');
      var stn = group.querySelector('.station[data-i="' + i + '"]');
      if (cap) cap.classList.toggle('hot', on);
      if (stn) stn.classList.toggle('hot', on);
    }
    document.querySelectorAll('.cap').forEach(function (cap) {
      var i = cap.getAttribute('data-i');
      cap.addEventListener('mouseenter', function () { hot(i, true); });
      cap.addEventListener('mouseleave', function () { hot(i, false); });
    });
  });
})();
