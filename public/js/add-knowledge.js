$(document).ready(function() {
    tinymce.init({
        selector: '#knowledge',
        height: 370,
        theme: 'modern',
        plugins : 'advlist autolink link image lists charmap print preview table code',
        menubar: false
    });
});

