/**
 * Comfort Foundation admin — CKEditor for every "richtext" field.
 *
 * CKEditor replaces each `<textarea class="js-ckeditor">` with its own UI
 * but does not keep the original textarea's value live-updated, so we sync
 * it back manually right before the form is submitted. Image uploads (drag
 * -drop or the toolbar button) go through admin/editor-upload, which reuses
 * the same handle_upload() pipeline as every other image field.
 */
(function () {
  'use strict';

  if (typeof ClassicEditor === 'undefined') { return; }

  var csrfToken = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
  var uploadUrl = (document.querySelector('meta[name="upload-url"]') || {}).content || '';

  function UploadAdapter(loader) {
    this.loader = loader;
  }
  UploadAdapter.prototype.upload = function () {
    var loader = this.loader;
    return loader.file.then(function (file) {
      var data = new FormData();
      data.append('upload', file);
      data.append('_token', csrfToken);
      return fetch(uploadUrl, { method: 'POST', body: data, credentials: 'same-origin' })
        .then(function (res) { return res.json(); })
        .then(function (json) {
          if (json.error) { return Promise.reject(json.error.message); }
          return { default: json.url };
        });
    });
  };
  UploadAdapter.prototype.abort = function () {};

  function attach(textarea) {
    ClassicEditor
      .create(textarea, {
        toolbar: [
          'heading', '|', 'bold', 'italic', 'underline', 'link', '|',
          'bulletedList', 'numberedList', 'blockQuote', '|',
          'insertTable', 'uploadImage', '|', 'undo', 'redo',
        ],
        heading: {
          options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading2', view: 'h3', title: 'Heading', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h4', title: 'Subheading', class: 'ck-heading_heading3' },
          ],
        },
      })
      .then(function (editor) {
        textarea._ckeditor = editor;
        editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
          return new UploadAdapter(loader);
        };
        var form = textarea.closest('form');
        if (form) {
          form.addEventListener('submit', function () { editor.updateSourceElement(); });
        }
      })
      .catch(function (err) {
        // The plain textarea (with its "HTML is allowed" hint) already works
        // as a fallback, so a failed editor load is not fatal — just log it.
        console.error('CKEditor failed to load:', err);
      });
  }

  document.querySelectorAll('textarea.js-ckeditor').forEach(attach);
})();
