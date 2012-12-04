jQuery(document).ready(function($){
    
    $('a[rel=fancybox]').fancybox({
        transitionIn: 'elastic',
        transitionOut: 'elastic',
        showNavArrows: false
    });
    
    $('a[rel=fancybox_ajax]').fancybox({
        transitionIn: 'elastic',
        transitionOut: 'elastic'
    });
    
    $('a.button').button();
    
    $('a.deleteRecord').click(function(event) {
        var odpoved = confirm('Naozaj chcete zmazať tento záznam?');
        if (!odpoved) {
            event.preventDefault();
        }
    });
    
});