import tinymce from 'tinymce';
import 'tinymce/themes/silver';
import 'tinymce/plugins/link';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/code';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/textcolor';

document.addEventListener("DOMContentLoaded", function () {
  tinymce.init({
    selector: '.tinymce',
    skin_url: '/build/skins/ui/oxide', // Tell TinyMCE where the skin is
    content_css: '/build/skins/content/default/content.css', // Tell TinyMCE where the content CSS is
    menubar: false,
    toolbar: [
      'undo redo | bold italic underline strikethrough | link | bullist numlist | fullscreen | code | styleselect fontselect fontsizeselect forecolor'
    ],
    plugins: [
      'link', 'fullscreen', 'paste', 'lists', 'code', 'textcolor'
    ],
    height: 400,
  });
});

