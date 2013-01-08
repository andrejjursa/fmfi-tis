{nocache}
$(document).ready(function(){
    
    var knownPhysicists = new Array();
    
    /**
     * This function will renew lists of physicists and inventions after stop sliding in slider.
     */
    sliderOnStop = function(event, ui) {
        var selected_year = ui.value;
        
        $('#timeline').slider('disable');
        
        var urlPatern = '{createUri controller="timeline" action="ajaxUpdateList" params=["-YEAR-","-PERIOD-"]}';
        $.ajax(urlPatern.replace('-YEAR-', selected_year).replace('-PERIOD-', '{$period}'), {
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
     * Updates information slider information box.
     */
    updateHandleInfo = function() {
        var pos = $('#timeline .ui-slider-handle').offset();
        var width = $('#timeline .ui-slider-handle').width();
        var height = $('#timeline .ui-slider-handle').height();
        var year = $('#timeline').slider('value');
        var info = '';
        var info_height = $('#timeline-info').height();
        var min = {$start_year nocache};
        var max = {$end_year nocache};
        var range = max - min;
        var current = year - min;
        var distance = range - current;
        var distance_p = distance / range;
        var plus_top = -1 * info_height * distance_p;
        var handle_plus = height * distance_p;
        $('#timeline-info')
			.css('display', 'block')
			.css('top', pos.top + plus_top + handle_plus)
			.css('left', pos.left + width);
			
        $('#timeline-info h1').html(year);
        for (i=0;i<knownPhysicists.length;i++) {
            if (knownPhysicists[i].birth_year <= year && year <= knownPhysicists[i].death_year) {
                info += '<p>' + knownPhysicists[i].name
                info += ' (' + knownPhysicists[i].birth_year;
                if (knownPhysicists[i].death_year < 9999) {
                    info += ' - ';
                    info += knownPhysicists[i].death_year;
                }
                info += ')</p>';
            }
        }
        if (info == '') {
            info = '<p>Žiadni fyzici v tomto roku.</p>';
        }
        $('#timeline-info .physicists').html(info);
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
            stop: sliderOnStop,
			value: {$year},
            slide: updateHandleInfo
        }).after('<div id="timeline-info"><p><h1></h1></p><div class="physicists"></div></div>').mouseover(updateHandleInfo).mouseout(function(){
            $('#timeline-info').css('display', 'none');
        });
        
        $('#timeline').css({
            'background-image': 'url(' + $('#dataForJS [name=background]').val() + ')',
            'background-position': 'top center',
            'background-repeat': 'no-repeat',
            'border-color': $('#dataForJS [name=border_color]').val()
        });
        $('#timeline a').fadeTo(0, 0.7).css('border-color', $('#dataForJS [name=border_color]').val());
        
        var url = '{createUri controller="timeline" action="ajaxTimelineInfoData" params=[$period]}';
        $.ajax(url, {
            cache: true,
            dataType: 'json',
            success: function(data) {
                knownPhysicists = data;
            }
        });
    }
    
    insertTimeline();
    
    updatePeriod = function() {
        var action = $(this).parent('form').attr('action');
        var period = $(this).val();
        var url = action.replace('-PERIOD-', period);
        window.location = url;
    }
    
    $('#period_selector').bind('change', updatePeriod);
    
});
{/nocache}