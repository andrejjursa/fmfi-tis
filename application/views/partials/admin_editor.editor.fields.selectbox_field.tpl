<div id="selectbox_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td class="content"><select name="data[{$field->getField()}]{if $field->getMultiple()}[]{/if}" id="{$field->getFieldHtmlID()}" size="{$field->getSize()}" class="form_field_select_box"{if $field->getMultiple()} multiple="multiple"{/if}>
            {html_options options=$field->getOptions() selected=$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:$field->getSelected()}
        </select></td>
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