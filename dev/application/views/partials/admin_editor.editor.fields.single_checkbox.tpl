<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label>
    {if $field->getCheckboxText()}<label for="{$field->getFieldHtmlID()}">{$field->getCheckboxText()}</label>{/if}
    <input type="checkbox" name="data[{$field->getField()}]" value="{$field->getDefaultValue()}" id="{$field->getFieldHtmlID()}" {if $smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getDefaultChecked()}checked="checked" {/if}/>
    <div class="error_container"></div>
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