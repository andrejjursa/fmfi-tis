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
        var year = $('#timeline').slider('value');
        var info = '';
        $('#timeline-info').css('display', '').css('top', pos.top).css('left', pos.left + width);
        $('#timeline-info .year').html(year);
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
            info = '<p>Žiadny fyzici v tomto roku.</p>';
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
        }).after('<div id="timeline-info" style="display: none; position: absolute; width: 200px; min-height: 200px; border: 1px solid black; background-color: white; z-index: 1000;"><p>Rok: <span class="year"></span></p><div class="physicists"></div></div>').mouseover(updateHandleInfo).mouseout(function(){
            $('#timeline-info').css('display', 'none');
        });
        
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
    
});
{/nocache}