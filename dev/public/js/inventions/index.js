$(document).ready(function(){
    
    prepareInventionDetail = function () {
        $('a[rel=fancybox]').fancybox({
            'titlePosition': 'over',
            'transitionIn': 'elastic',
            'transitionOut': 'elastic'
        });
        
        $('a[rel=fancybox_ajax]').fancybox({ showNavArrows: false });
        
        $('a[rel=fancybox_inline]').each(function(){
            var width = $(this).find('span.link_width').text();
            var height = $(this).find('span.link_height').text();
            if (width == undefined || width == null) { width = '100%'; }
            if (height == undefined || height == null) { height = '100%'; }
            if (parseInt(width) == width) { width = parseInt(width); }
            if (parseInt(height) == height) { height = parseInt(height); }
            var options = {
                showNavArrows: false,
                'type': 'iframe',
                'autoDimensions': false,
                'transitionIn': 'elastic',
                'transitionOut': 'elastic',
                'width': width,
                'height': height
            };
            $(this).fancybox(options);
        });
        
        $('a[rel=popup]').each(function(){
            var href = $(this).attr('href');
            var width = $(this).find('span.link_width').text();
            var height = $(this).find('span.link_height').text();
            if (width == undefined || width == null) { width = '100%'; }
            if (height == undefined || height == null) { height = '100%'; }
            if (parseInt(width) == width) { width = parseInt(width); }
            if (parseInt(height) == height) { height = parseInt(height); }
            $(this).click(function(event) {
                event.preventDefault();
                window.open(href, '', 'width=' + width + ',height=' + height + ',top=0,left=0,toolbar=no,titlebar=yes,scrollbars=yes,resizable=yes,location=no,status=yes,menubar=no');    
            });
        });
        
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