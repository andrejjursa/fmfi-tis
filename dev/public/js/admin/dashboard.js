jQuery(document).ready(function($) {
    
    var url = $('#site_base_url_id').text() + 'index.php/admin_editor/ajaxInlineGrid/logs/5/crdate-desc/';
    
    $.ajax(url, {
        cache: false,
        dataType: 'json',
        success: function(data) {
            $('#last_logs').html(data);
            refreshGrid();
        }
    });
    
});