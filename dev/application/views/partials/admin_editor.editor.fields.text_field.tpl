<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label>
    <input type="text" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getDefaultText()|escape:'html'}" id="{$field->getFieldHtmlID()}" />
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