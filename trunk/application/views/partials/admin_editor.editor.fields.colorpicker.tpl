<div id="colorpicker_field_{$field->getFieldHtmlID()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td colspan="2"><span id="color_info_{$field->getFieldHtmlID()}"></span></td>
    </tr><tr>
        <td></td>
        <td><div id="colorpicker_{$field->getFieldHtmlID()}" class="colorpicker">
            <div class="colorpreviewbox">Ukážka</div>
            <div class="colorsliders">
                <div class="slider_wrapper"><div class="slider_red"></div></div>
                <div class="slider_wrapper"><div class="slider_green"></div></div>
                <div class="slider_wrapper"><div class="slider_blue"></div></div>
            </div>
            <div class="clear"></div>
        </div><input type="hidden" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getDefaultColor()|escape:'html'}" id="{$field->getFieldHtmlID()}" /></td>
        <td class="errors"><div class="error_container"></div></td>
    </tr></tbody></table>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
            var init_color_{$field->getFieldHtmlID()} = hexToRgb($('#{$field->getFieldHtmlID()}').val());
            var not_changed_{$field->getFieldHtmlID()} = true; 
            $('#colorpicker_{$field->getFieldHtmlID()} div.slider_red').slider({ range: 'min', min: 0, max: 255, value: init_color_{$field->getFieldHtmlID()}.r, slide: on_slide_{$field->getFieldHtmlID()}, change: on_slide_{$field->getFieldHtmlID()} });
            $('#colorpicker_{$field->getFieldHtmlID()} div.slider_green').slider({ range: 'min', min: 0, max: 255, value: init_color_{$field->getFieldHtmlID()}.g, slide: on_slide_{$field->getFieldHtmlID()}, change: on_slide_{$field->getFieldHtmlID()} });
            $('#colorpicker_{$field->getFieldHtmlID()} div.slider_blue').slider({ range: 'min', min: 0, max: 255, value: init_color_{$field->getFieldHtmlID()}.b, slide: on_slide_{$field->getFieldHtmlID()}, change: on_slide_{$field->getFieldHtmlID()} });
            function on_slide_{$field->getFieldHtmlID()}() {
                var red = $('#colorpicker_{$field->getFieldHtmlID()} div.slider_red').slider('value');
                var green = $('#colorpicker_{$field->getFieldHtmlID()} div.slider_green').slider('value');
                var blue = $('#colorpicker_{$field->getFieldHtmlID()} div.slider_blue').slider('value');
                var text_red = 255 - red;
                var text_blue = 255 - blue;
                var text_green = 255 - green;
                var hex_color = rgbToHex(red, green, blue);
                var text_hex_color = rgbToHex(text_red, text_green, text_blue);
                
                var info = hex_color + ' (' + red + ', ' + green + ', ' + blue + ')';
                
                $('#colorpicker_{$field->getFieldHtmlID()} div.colorpreviewbox').css('background-color', hex_color).css('color', text_hex_color);
                
                if (not_changed_{$field->getFieldHtmlID()} && $('#{$field->getFieldHtmlID()}').val() != hex_color) {
                    highlightChange();
                    not_changed_{$field->getFieldHtmlID()} = false;
                }
                $('#{$field->getFieldHtmlID()}').val(hex_color);
                $('#color_info_{$field->getFieldHtmlID()}').text(info);
            }
            
            on_slide_{$field->getFieldHtmlID()}();
        });
    </script>
</div>