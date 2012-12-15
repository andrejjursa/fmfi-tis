<div id="mm_relation_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td><div class="error_container"></div></td>
    </tr><tr>
        <td colspan="2">
        {if $field->getEditOnly() and !$id}
            <p>Táto položka sa dá upravovať až po uložení záznamu.</p>
        {else}
            <input type="hidden" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:'0'|escape:'html'}" id="{$field->getFieldHtmlID()}" />
            {capture assign="items_header"}
            <ul style="min-height: 20px; padding: 10px; border: 1px solid black; list-style-type: none; background-color: white; border-radius: 4px;">
                <li>
                    <table style="width: 100%; border-collapse: collapse;">
                    <tbody><tr>
                        {foreach $field->getGridFields() as $gridField}
                            <td style="width: {$gridField->getWidth()};"><strong>{$gridField->getName()}</strong></td>
                        {/foreach}
                    </tr></tbody>
                    </table>
                </li>
            </ul>{/capture}
            <table id="{$field->getFieldHtmlID()}_relations_table" class="mm_relation_table" style="width: 100%; border-collapse: collapse;">
                <tbody>
                    {if $field->getFilterInFields()}
                    <tr>
                        <td colspan="2">Súčasný filter: <span id="{$field->getFieldHtmlID()}_relations_table_filter"></span> <button id="filter_mm_relation_button_{$field->getFieldHtmlID()}" type="button" class="button">Filtrovať</button> <a href="{createUri controller='admin_editor' action='newRecordIframe' params=[$field->getForeignTable()]}" id="add_new_relate_item_{$field->getFieldHtmlID()}" class="button">Vytvoriť nový záznam</a></td>
                    </tr>
                    {/if}
                    <tr>
                        <td>{$items_header}</td>
                        <td>{$items_header}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%; vertical-align: top; border: 1px solid black;">
                            <div id="{$field->getFieldHtmlID()}_relations_selected" class="mm_relation_container connect_with_{$field->getField()}" style="max-height: 500px; width: 100%; overflow-y: auto;"></div>
                        </td>
                        <td style="width: 50%; vertical-align: top; border: 1px solid black;">
                            <div id="{$field->getFieldHtmlID()}_relations_available" class="mm_relation_container connect_with_{$field->getField()}" style="max-height: 500px; width: 100%; overflow-y: auto;"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
                    
                    function make_sortable_for_{$field->getFieldHtmlID()}() {
                        $('#{$field->getFieldHtmlID()}_relations_selected ul').sortable({
                            connectWith: '.connect_with_{$field->getField()} ul',
                            placeholder: 'sortable-highlight',
                            update: function(event, ui) {
                                var row_ids = '';
                                $('#{$field->getFieldHtmlID()}_relations_selected ul li').each(function() {
                                    var row_id = $(this).attr('row_id');
                                    if (row_ids != '') { row_ids += ','; }
                                    row_ids += row_id;
                                });
                                $('#{$field->getFieldHtmlID()}').val(row_ids).valid();
                                highlightChange();
                            }
                        }).disableSelection();
                        
                        $('#{$field->getFieldHtmlID()}_relations_available ul').sortable({
                            connectWith: '.connect_with_{$field->getField()} ul',
                            placeholder: 'sortable-highlight'
                        }).disableSelection();
                    }
                    
                    $.ajax('{createUri controller="admin_editor" action="mm_relation_field" params=[$sql_table, $field->getField()]}', {
                        cache: false,
                        dataType: 'html',
                        type: 'post',
                        data: { onlyIds: $('#{$field->getFieldHtmlID()}').val() },
                        success: function(data) {
                            $('#{$field->getFieldHtmlID()}_relations_selected').html(data);
                            make_sortable_for_{$field->getFieldHtmlID()}();
                            $('#{$field->getFieldHtmlID()}_relations_selected a[rel=fancybox]').fancybox({
                                transitionIn: 'elastic',
                                transitionOut: 'elastic',
                                showNavArrows: false
                            });
                        } 
                    });
                    
                    function load_list_for_{$field->getFieldHtmlID()}(filter) {
                        $.ajax('{createUri controller="admin_editor" action="mm_relation_field" params=[$sql_table, $field->getField()]}', {
                            cache: false,
                            dataType: 'html',
                            type: 'post',
                            data: { excludeIds: $('#{$field->getFieldHtmlID()}').val(), like: filter },
                            success: function(data) {
                                $('#{$field->getFieldHtmlID()}_relations_available').html(data);
                                make_sortable_for_{$field->getFieldHtmlID()}();
                                $('#{$field->getFieldHtmlID()}_relations_available a[rel=fancybox]').fancybox({
                                    transitionIn: 'elastic',
                                    transitionOut: 'elastic',
                                    showNavArrows: false
                                });
                            } 
                        });
                    }
                    
                    function reload_with_filter_{$field->getFieldHtmlID()}() {
                        var filter = prompt('Zadaj filtrovací text:', $('#{$field->getFieldHtmlID()}_relations_table_filter').text());
                        if (filter != null) {
                            $('#{$field->getFieldHtmlID()}_relations_table_filter').text(filter);
                            
                            load_list_for_{$field->getFieldHtmlID()}(filter);
                        }   
                    };
                    
                    $('#filter_mm_relation_button_{$field->getFieldHtmlID()}').click(reload_with_filter_{$field->getFieldHtmlID()});
                    
                    $('#add_new_relate_item_{$field->getFieldHtmlID()}').click(function(event) {
                        event.preventDefault();
                        var href = $(this).attr('href');
                        var wnd = window.open(href, '', 'width=800, height=600');
                        if (wnd) {
                            wnd.onunload = function() {
                                var filter = $('#{$field->getFieldHtmlID()}_relations_table_filter').text();
                                
                                load_list_for_{$field->getFieldHtmlID()}(filter);
                            }
                        }
                    });
                    
                    load_list_for_{$field->getFieldHtmlID()}('');
                });
            </script>
        {/if}
        </td>
    </tr></tbody></table>
</div>