/* public-theme.js — theme toggle + hero book-stack rotation */
(function () {
    'use strict';

    /* ── Theme toggle ─────────────────────────────────────────── */
    var btn  = document.getElementById('theme-toggle');
    var icon = document.getElementById('theme-icon');

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            if (icon) { icon.classList.remove('bi-moon'); icon.classList.add('bi-sun'); }
        } else {
            document.documentElement.removeAttribute('data-theme');
            if (icon) { icon.classList.remove('bi-sun'); icon.classList.add('bi-moon'); }
        }
    }

    /* Sync icon to whatever the init script already applied */
    try {
        var saved = localStorage.getItem('gb-theme') || 'light';
        applyTheme(saved);
    } catch (e) {}

    if (btn) {
        btn.addEventListener('click', function () {
            var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            try { localStorage.setItem('gb-theme', next); } catch (e) {}
        });
    }

    /* ── Hero book-stack rotation ─────────────────────────────── */
    var stack = document.getElementById('heroBookStack');
    if (!stack) return;

    /* Respect prefers-reduced-motion */
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var books = Array.from(stack.querySelectorAll('.gb-stack-book'));
    if (books.length < 2) return;

    var n = books.length;

    function rotateStack() {
        books.forEach(function (book) {
            var pos = (parseInt(book.getAttribute('data-pos'), 10) + 1) % n;
            book.setAttribute('data-pos', pos);
        });
    }

    /* Auto-rotate every 4 seconds */
    var timer = setInterval(rotateStack, 4000);

    /* On hover: rotate immediately then reset the interval */
    stack.addEventListener('mouseenter', function () {
        clearInterval(timer);
        rotateStack();
        timer = setInterval(rotateStack, 4000);
    });

    /* Pause auto-rotation when the tab is hidden */
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            clearInterval(timer);
        } else {
            timer = setInterval(rotateStack, 4000);
        }
    });
}());
