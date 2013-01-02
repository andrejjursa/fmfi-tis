<div id="single_checkbox_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td class="content">{if $field->getCheckboxText()}<label for="{$field->getFieldHtmlID()}">{$field->getCheckboxText()}</label>{/if}<input type="checkbox" name="data[{$field->getField()}]" value="{$field->getDefaultValue()}" id="{$field->getFieldHtmlID()}" {if $smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getDefaultChecked()}checked="checked" {/if}/></td>
        <td class="errors"><div class="error_container"></div></td>
    </tr></tbody></table>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
            $('#{$field->getFieldHtmlID()}').bind('change', function() {
                highlightChange();
                $(this).valid();
            });
        });
    </script>
</div>