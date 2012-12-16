$(document).ready(function(){
    
    prepareInventionDetail = function () {
        $('a[rel=fancybox]').fancybox({
            'titlePosition': 'over',
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
        
        $('a[rel=fancybox_ajax]').fancybox({ showNavArrows: false });
    }
    
    prepareInventionDetail();
    
});