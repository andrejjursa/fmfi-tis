<div id="tinymce_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td><div class="error_container"></div></td>
    </tr><tr>
        <td colspan="2"><textarea class="tinymce" style="width: 100%;" rows="{$field->getNumberOfRows()}" name="data[{$field->getField()}]" id="{$field->getFieldHtmlID()}">{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getDefaultText()|escape:'html'}</textarea></td>
    </tr></tbody></table>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
        });
    </script>
</div>