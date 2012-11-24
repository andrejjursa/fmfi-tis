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
    
});