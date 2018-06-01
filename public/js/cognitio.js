$(document).ready(function() {
    setTimeout(function() {
        $(".alert").remove(); 
    }, 5000);

    var $rows = $('#knowledge-table tr');
    $('.search').keyup(function() {
        
        var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
            reg = RegExp(val, 'i'),
            text;
        
        $rows.show().filter(function() {
            text = $(this).text().replace(/\s+/g, ' ');
            return !reg.test(text);
        }).hide();
    });
});