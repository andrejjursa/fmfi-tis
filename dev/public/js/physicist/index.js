$(document).ready(function(){
    var height = window.innerHeight - 100;
	
    preparePhysicistDetail = function () {
        $('a[rel=fancybox]').fancybox({
            'titlePosition': 'over',
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
        
        $('a[rel=fancybox_ajax]').fancybox({ showNavArrows: false });
        
        $('#doTestLink').fancybox({
            'width': 800,
            'height': height,
            'autoDimensions': false,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
    }
    
    preparePhysicistDetail();
    
});