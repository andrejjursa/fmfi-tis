jQuery(document).ready(function($) {
   
    $.ajax('/index.php/admin_editor/ajaxInlineGrid/logs/5/crdate-desc/', {
        cache: false,
        dataType: 'json',
        success: function(data) {
            $('#last_logs').html(data);
            refreshGrid();
        }
    });
    
});