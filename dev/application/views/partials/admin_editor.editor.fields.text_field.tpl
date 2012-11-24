<div id="text_field_{$field->getField()}" class="highlight_field">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label>
    <input type="text" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|escape:'html'}" id="{$field->getFieldHtmlID()}" />
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
        });
    </script>
</div>