<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label><div class="error_container"></div>
    <textarea class="tinymce" style="width: 100%; height: 500px;" name="data[{$field->getField()}]" id="{$field->getFieldHtmlID()}">{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|escape:'html'}</textarea>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
        });
    </script>
</div>