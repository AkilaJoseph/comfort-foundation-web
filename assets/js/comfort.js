/* =====================================================================
   Comfort Foundation — site behaviour
   Small additions on top of the template's custom.js.
   ===================================================================== */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    /* ---- copy-to-clipboard on the Donate page --------------------- */
    document.querySelectorAll('.cf-copy-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var target = document.querySelector(btn.getAttribute('data-copy'));
        if (!target) { return; }
        var text = (target.textContent || '').trim();
        var done = function () {
          var original = btn.textContent;
          btn.textContent = 'Copied';
          btn.style.background = '#21B24B';
          btn.style.color = '#fff';
          setTimeout(function () {
            btn.textContent = original;
            btn.style.background = '';
            btn.style.color = '';
          }, 1800);
        };
        if (navigator.clipboard && window.isSecureContext) {
          navigator.clipboard.writeText(text).then(done).catch(fallback);
        } else {
          fallback();
        }
        function fallback() {
          var ta = document.createElement('textarea');
          ta.value = text;
          ta.style.position = 'fixed';
          ta.style.opacity = '0';
          document.body.appendChild(ta);
          ta.select();
          try { document.execCommand('copy'); done(); } catch (e) { /* ignore */ }
          document.body.removeChild(ta);
        }
      });
    });

    /* ---- gallery category filter --------------------------------- */
    var filters = document.querySelectorAll('.cf-gallery-filter');
    if (filters.length) {
      filters.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var want = btn.getAttribute('data-filter');
          filters.forEach(function (b) {
            b.classList.remove('active');
            b.classList.remove('btn--primary');
            b.classList.add('btn--tertiary');
          });
          btn.classList.add('active');
          btn.classList.remove('btn--tertiary');
          btn.classList.add('btn--primary');

          document.querySelectorAll('.cf-gallery-item').forEach(function (item) {
            var show = want === '*' || item.getAttribute('data-category') === want;
            item.style.display = show ? '' : 'none';
          });
        });
      });
    }

    /* ---- lightbox for gallery images ------------------------------ */
    if (window.jQuery && jQuery.fn.magnificPopup && document.querySelector('.cf-lightbox')) {
      jQuery('#cfGallery').magnificPopup({
        delegate: 'a.cf-lightbox',
        type: 'image',
        gallery: { enabled: true, navigateByImgClick: true },
        image: { titleSrc: 'title' }
      });
    }

    /* ---- auto-dismiss flash messages ------------------------------ */
    document.querySelectorAll('.cf-alert').forEach(function (el) {
      setTimeout(function () {
        el.style.transition = 'opacity .5s ease, max-height .5s ease, margin .5s ease';
        el.style.opacity = '0';
        el.style.maxHeight = '0';
        el.style.marginBottom = '0';
        el.style.overflow = 'hidden';
      }, 9000);
    });

    /* ---- scroll a flash message into view -------------------------- */
    var firstAlert = document.querySelector('.cf-alert');
    if (firstAlert) {
      var top = firstAlert.getBoundingClientRect().top + window.pageYOffset - 140;
      window.scrollTo({ top: top, behavior: 'smooth' });
    }

    /* ---- guard against double form submission ---------------------- */
    document.querySelectorAll('form[method="post"]').forEach(function (form) {
      form.addEventListener('submit', function () {
        var btn = form.querySelector('button[type="submit"]');
        if (!btn || btn.dataset.busy) { return; }
        btn.dataset.busy = '1';
        setTimeout(function () {
          btn.disabled = true;
          btn.style.opacity = '.65';
        }, 10);
        setTimeout(function () {
          btn.disabled = false;
          btn.style.opacity = '';
          delete btn.dataset.busy;
        }, 8000);
      });
    });

  });
})();
