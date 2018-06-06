$(document).ready(function() {
    tinymce.init({
        selector: '#knowledge',
        height: 370,
        theme: 'modern',
        plugins : 'advlist autolink link image media lists charmap print preview table code',
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | table",
        menubar: false,
        relative_urls: false,
        images_upload_url: '/uploadImages',
        images_upload_base_path: '/uploads',
        init_instance_callback : function() {
            $('#mceu_32').remove();
        }
    });

    $('.select-category').select2({
        language: "pt-BR",
        placeholder: "Categoria",
        allowClear: true
    });
});

