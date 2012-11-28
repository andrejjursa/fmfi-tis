<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label>
    {if $field->getEditOnly() and !$id}
        Táto položka sa dá upravovať až po uložení záznamu.
    {else}
        <input type="hidden" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|default:'0'|escape:'html'}" id="{$field->getFieldHtmlID()}" />
        <div class="error_container"></div>
        <table id="{$field->getFieldHtmlID()}_relations_table" class="mm_relation_table" style="width: 100%; border-collapse: collapse;">
            <tbody>
                {if $field->getFilterInFields()}
                <tr>
                    <td colspan="2">Súčasný filter: <span id="{$field->getFieldHtmlID()}_relations_table_filter"></span> <button id="filter_mm_relation_button_{$field->getFieldHtmlID()}" type="button">Filtrovať</button></td>
                </tr>
                {/if}
                <tr>
                    <td id="{$field->getFieldHtmlID()}_relations_selected" style="width: 50%; vertical-align: top;" class="mm_relation_container connect_with_{$field->getField()}"></td>
                    <td id="{$field->getFieldHtmlID()}_relations_available" style="width: 50%; vertical-align: top;" class="mm_relation_container connect_with_{$field->getField()}"></td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#{$field->getFieldHtmlID()}').rules('add', {$field->getRulesJSON()});
                
                function make_sortable_for_{$field->getFieldHtmlID()}() {
                    $('#{$field->getFieldHtmlID()}_relations_selected ul').sortable({
                        connectWith: '.connect_with_{$field->getField()} ul',
                        placeholder: 'ui-state-highlight',
                        update: function(event, ui) {
                            var row_ids = '';
                            $('#{$field->getFieldHtmlID()}_relations_selected ul li').each(function() {
                                var row_id = $(this).attr('row_id');
                                if (row_ids != '') { row_ids += ','; }
                                row_ids += row_id;
                            });
                            $('#{$field->getFieldHtmlID()}').val(row_ids).valid();
                        }
                    }).disableSelection();
                    
                    $('#{$field->getFieldHtmlID()}_relations_available ul').sortable({
                        connectWith: '.connect_with_{$field->getField()} ul',
                        placeholder: 'ui-state-highlight'
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
                        } 
                    });
                }
                
                $('#filter_mm_relation_button_{$field->getFieldHtmlID()}').click(function() {
                    var filter = prompt('Zadaj filtrovací text:', $('#{$field->getFieldHtmlID()}_relations_table_filter').text());
                    if (filter != null) {
                        $('#{$field->getFieldHtmlID()}_relations_table_filter').text(filter);
                        
                        load_list_for_{$field->getFieldHtmlID()}(filter);
                    }   
                });
                
                load_list_for_{$field->getFieldHtmlID()}('');
            });
        </script>
    {/if}
</div>