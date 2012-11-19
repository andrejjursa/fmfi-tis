$(document).ready(function(){
    
    preparePhysicistDetail = function () {
        $('a[rel=fancybox]').fancybox({
            'titlePosition': 'over',
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
        
        $('#doTestLink').fancybox({
            'width': 800,
            'height': 600,
            'autoDimensions': false,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
    }
    
    preparePhysicistDetail();
    
});