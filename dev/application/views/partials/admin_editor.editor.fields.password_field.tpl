<div id="password_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td class="content"><input type="password" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|escape:'html'}" id="{$field->getFieldHtmlID()}" class="form_field_text_input" /></td>
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