$(document).ready(function(){
    
    /**
     * This function will renew lists of physicists and inventions after stop sliding in slider.
     */
    sliderOnStop = function(event, ui) {
        var selected_year = ui.value;
        
        $('#timeline').slider('disable');
        
        var urlPatern = '{createUri controller="timeline" action="ajaxUpdateList" params=["-YEAR-"] nocache}';
        $.ajax(urlPatern.replace('-YEAR-', selected_year), {
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#physicists_container').html(data.physicists);
                $('#inventions_container').html(data.inventions);
            },
            complete: function() {
                $('#timeline').slider('enable');
            }
        });
    }
    
    /**
     * Creates slider and all its handlers.
     */
    insertTimeline = function() {
        $('#timeline').slider({
            orientation: "vertical",
            range: false,
            min: {$start_year nocache},
            max: {$end_year nocache},
            stop: sliderOnStop
        });
    }
    
    insertTimeline();
    
});