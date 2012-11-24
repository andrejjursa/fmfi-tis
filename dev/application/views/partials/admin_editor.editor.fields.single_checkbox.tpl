<div id="text_field_{$field->getField()}" class="highlight_field">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label>
    {if $field->getCheckboxText()}<label for="{$field->getFieldHtmlID()}">{$field->getCheckboxText()}</label>{/if}
    <input type="checkbox" name="data[{$field->getField()}]" value="{$field->getDefaultValue()}" id="{$field->getFieldHtmlID()}" {if $smarty.post.data[$field->getField()]|default:$field->getDefaultChecked()}checked="checked" {/if}/>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
        });
    </script>
</div>