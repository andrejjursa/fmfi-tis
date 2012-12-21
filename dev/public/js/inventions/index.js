$(document).ready(function(){
    
    prepareInventionDetail = function () {
        $('a[rel=fancybox]').fancybox({
            'titlePosition': 'over',
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
        
        $('a[rel=fancybox_ajax]').fancybox({ showNavArrows: false });
        
        $('a.external-link').fancybox({
            width: '100%',
            height: '100%',
            transitionIn: 'elastic',
            transitionOut: 'elastic',
            type: 'iframe'
        });
    }
    
    prepareInventionDetail();
    
});