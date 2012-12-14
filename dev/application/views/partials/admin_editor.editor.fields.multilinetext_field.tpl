<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label><br />
    <div class="error_container"></div>
    <textarea style="width: 100%;" rows="{$field->getNumberOfRows()}" name="data[{$field->getField()}]" id="{$field->getFieldHtmlID()}">{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getDefaultText()|escape:'html'}</textarea>
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