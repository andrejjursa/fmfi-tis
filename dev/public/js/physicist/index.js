$(document).ready(function(){
    
    var physicist_id = 0;
    var dotest_url = '';
    
    startTest = function(event) {
        event.preventDefault();
        
        $.fancybox({
            type: 'ajax',
            width: 800,
            height: 600,
            ajax: {
                url: dotest_url.replace('-ID-', physicist_id),
                cache: false
            }
        });
    }
    
    preparePhysicistDetail = function () {
        physicist_id = $('#physicist_name').attr('physicist_id');
        dotest_url =  $('#physicist_name').attr('linkToDoTest');
        
        $('#doTest').click(startTest);
    }
    
    preparePhysicistDetail();
    
});