jQuery(document).ready(function($){
    
    $('a[rel=fancybox]').fancybox({
        transitionIn: 'elastic',
        transitionOut: 'elastic',
        showNavArrows: false
    });
    
    $('a[rel=fancybox_ajax]').fancybox({
        width: '100%',
        height: '100%',
        transitionIn: 'elastic',
        transitionOut: 'elastic',
        type: 'iframe'
    });
    
    $('a[rel=popup_window]').click(function(event) {
        event.preventDefault();
        window.open($(this).attr('href'), '', 'width=800,height=600,left=10,top=10,toolbar=no,status=no,scrollbars=yes,titlebar=yes,menubar=no,location=no,fullscreen=no,directories=no,channelmode=no');
    });
    
    $('a.button').button();
    
    $('a.deleteRecord').click(function(event) {
        var odpoved = confirm('Naozaj chcete zmazať tento záznam?');
        if (!odpoved) {
            event.preventDefault();
        }
    });
    
});