<div id="iframe_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td>{if $id}<button type="button" id="{$field->getFieldHtmlID()}_add_record" class="button">Pridať záznam</button>{/if}</td>
    </tr><tr>
        <td colspan="2">
            {if !$id}
                <p>Táto položka sa dá upravovať až po uložení záznamu.</p>
            {else}
                <div id="{$field->getFieldHtmlID()}_records">
                    {foreach $data[$field->getField()] as $record_id}
                    <iframe src="{createUri controller='admin_editor' action='editRecordIframe' params=[$field->getForeignTable(),$record_id,$id,$sql_table]}" style="width: 100%; backgound-color: white; border: 1px solid silver;"></iframe>
                    {/foreach}
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function($) {
                        
                        $('#{$field->getFieldHtmlID()}_records iframe').iframeAutoHeight({
                            {if is_integer($field->getMinimumHeight())}minHeight: {$field->getMinimumHeight()}{/if}
                        });
                        
                        $('#{$field->getFieldHtmlID()}_add_record').click(function(){
                            $('<iframe />', {
                                'src': '{createUri controller="admin_editor" action="newRecordIframe" params=[$field->getForeignTable(),$id,$sql_table]}',
                                'style': 'width: 100%; backgound-color: white; border: 1px solid silver;'
                            }).prependTo('#{$field->getFieldHtmlID()}_records').iframeAutoHeight({
                                {if is_integer($field->getMinimumHeight())}minHeight: {$field->getMinimumHeight()}{/if}
                            });                        
                        });
                        
                    });
                </script>
            {/if}
        </td>
    </tr></tbody></table>
    
</div>