/**
 * Comfort Foundation admin — crop-before-upload.
 *
 * Every `<input type="file" class="js-crop-input">` gets intercepted on
 * change: instead of uploading the file as chosen, we open a modal
 * cropper (Cropper.js) over it, then replace the input's file with the
 * cropped result before the form is ever submitted. The server side
 * (handle_upload()) never knows the difference — it just receives a
 * normal image upload.
 */
(function () {
  'use strict';

  var modal, cropperImg, cropperInstance, activeInput, activeTarget;

  function parseAspect(raw) {
    if (!raw || raw === 'free') { return NaN; }
    var parts = raw.split('/');
    if (parts.length === 2) {
      var w = parseFloat(parts[0]), h = parseFloat(parts[1]);
      if (w > 0 && h > 0) { return w / h; }
    }
    return NaN;
  }

  function buildModal() {
    if (modal) { return; }
    modal = document.createElement('div');
    modal.className = 'crop-modal';
    modal.innerHTML =
      '<div class="crop-modal__panel">' +
        '<div class="crop-modal__head">' +
          '<h3>Crop image</h3>' +
          '<p>Drag to reposition, drag the corners to resize the frame, then apply.</p>' +
        '</div>' +
        '<div class="crop-modal__stage"><img id="cropModalImg" alt=""></div>' +
        '<div class="crop-modal__foot">' +
          '<button type="button" class="btn btn--ghost" data-crop-cancel>Cancel</button>' +
          '<button type="button" class="btn btn--ghost" data-crop-skip>Use original, uncropped</button>' +
          '<button type="button" class="btn" data-crop-apply><i class="fa-solid fa-crop-simple"></i> Apply crop</button>' +
        '</div>' +
      '</div>';
    document.body.appendChild(modal);
    cropperImg = modal.querySelector('#cropModalImg');

    modal.querySelector('[data-crop-cancel]').addEventListener('click', closeModal);
    modal.querySelector('[data-crop-skip]').addEventListener('click', function () {
      if (activeInput && activeInput._cropOriginalFile) {
        useFile(activeInput._cropOriginalFile, URL.createObjectURL(activeInput._cropOriginalFile));
      }
      closeModal();
    });
    modal.querySelector('[data-crop-apply]').addEventListener('click', applyCrop);
    modal.addEventListener('click', function (ev) {
      if (ev.target === modal) { closeModal(); }
    });
  }

  function openModal(input, file, aspect) {
    buildModal();
    activeInput = input;
    activeTarget = document.getElementById(input.dataset.target || '');
    var url = URL.createObjectURL(file);
    input._cropOriginalFile = file;

    modal.classList.add('is-open');
    cropperImg.src = url;

    // Cropper needs the image actually loaded before it can measure it.
    cropperImg.onload = function () {
      if (cropperInstance) { cropperInstance.destroy(); }
      cropperInstance = new Cropper(cropperImg, {
        aspectRatio: aspect,
        viewMode: 1,
        autoCropArea: 1,
        background: false,
        responsive: true,
      });
    };
  }

  function closeModal() {
    if (!modal) { return; }
    modal.classList.remove('is-open');
    if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
    if (activeInput && !activeInput._cropHandled) {
      // Neither applied nor skipped — treat as a cancelled selection.
      activeInput.value = '';
    }
    activeInput = null;
    activeTarget = null;
  }

  function applyCrop() {
    if (!cropperInstance || !activeInput) { return; }
    var canvas = cropperInstance.getCroppedCanvas({
      imageSmoothingQuality: 'high',
    });
    if (!canvas) { closeModal(); return; }
    canvas.toBlob(function (blob) {
      if (!blob) { closeModal(); return; }
      var origName = (activeInput._cropOriginalFile && activeInput._cropOriginalFile.name) || 'photo.jpg';
      var stem = origName.replace(/\.[a-z0-9]+$/i, '');
      var file = new File([blob], stem + '-cropped.jpg', { type: 'image/jpeg' });
      useFile(file, URL.createObjectURL(blob));
      closeModal();
    }, 'image/jpeg', 0.9);
  }

  function useFile(file, previewUrl) {
    if (!activeInput) { return; }
    activeInput._cropHandled = true;
    try {
      var dt = new DataTransfer();
      dt.items.add(file);
      activeInput.files = dt.files;
    } catch (e) {
      // Very old browsers without DataTransfer construction support just
      // keep the browser's original file selection — cropping is a nice-
      // to-have, not a requirement for the upload to work.
    }
    if (activeTarget) {
      var img = activeTarget.querySelector('img');
      if (img) { img.src = previewUrl; }
      activeTarget.style.display = '';
    }
  }

  document.addEventListener('change', function (ev) {
    var input = ev.target.closest && ev.target.closest('.js-crop-input');
    if (!input || !input.files || !input.files[0]) { return; }
    if (typeof Cropper === 'undefined') { return; } // library failed to load — fall back to a plain upload
    input._cropHandled = false;
    var file = input.files[0];
    var aspect = parseAspect(input.dataset.aspect);
    openModal(input, file, aspect);
  });
})();
