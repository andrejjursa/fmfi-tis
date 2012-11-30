<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label>
    {if !$id}
        <p>Táto položka sa dá upravovať až po uložení záznamu.</p>
    {else}
        <button type="button" id="{$field->getFieldHtmlID()}_add_record">Pridať záznam</button>
        <div id="{$field->getFieldHtmlID()}_records">
            {foreach $data[$field->getField()] as $record_id}
            <iframe src="{createUri controller='admin_editor' action='editRecordIframe' params=[$field->getForeignTable(),$record_id,$id,$sql_table]}" style="width: 100%; backgound-color: white; border: 1px solid silver;"></iframe>
            {/foreach}
        </div>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                
                $('#{$field->getFieldHtmlID()}_records iframe').iframeAutoHeight();
                
                $('#{$field->getFieldHtmlID()}_add_record').click(function(){
                    $('<iframe />', {
                        'src': '{createUri controller="admin_editor" action="newRecordIframe" params=[$field->getForeignTable(),$id,$sql_table]}',
                        'style': 'width: 100%; backgound-color: white; border: 1px solid silver;'
                    }).prependTo('#{$field->getFieldHtmlID()}_records').iframeAutoHeight();                        
                });
                
            });
        </script>
    {/if}
</div>