tinymce.init({
  selector: 'textarea',
  height: 600,
  menubar: false,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
  ],
  toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table',
  content_css: [
    '/resource/css/style.css',
    '//www.tinymce.com/css/codepen.min.css',
	'/resource/css/tinymce.css']
});