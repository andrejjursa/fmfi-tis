<div id="fileupload_field_{$field->getField()}" class="highlight_field editor_field_line">
    <table class="formtable"><tbody><tr>
        <td class="label"><label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label></td>
        <td><input type="file" name="uploader_{$field->getField()}" value="" id="{$field->getFieldHtmlID()}" /> <span id="{$field->getFieldHtmlID()}_download">{if $smarty.post.data[$field->getField()]|default:$data[$field->getField()]}<a href="{$site_base_url}{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]}" target="_blank">Stiahnuť</a>{/if}</span> <span id="{$field->getFieldHtmlID()}_delete"><button type="button" style="{{if $smarty.post.data[$field->getField()]|default:$data[$field->getField()]}}{else}display: none;{/if}" class="button deleteRecord">Vymazať</button></span></td>
        <td class="errors"><div class="error_container"></div></td>
    </tr><tr>
        <td></td>
        <td colspan="2">
            <div id="{$field->getFieldHtmlID()}_queue"></div>
            <input type="hidden" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|escape:'html'}" id="{$field->getFieldHtmlID()}_hidden" />
            <input type="hidden" name="delete_files[{$field->getField()}]" value="" id="{$field->getFieldHtmlID()}_delete_files" />
        </td>
    </tr>{if $field->getShowFilePath()}<tr>
        <td class="label">Cesta k súboru:</td>
        <td colspan="2"><span id="{$field->getFieldHtmlID()}_path_to_file">{if !empty($data[$field->getField()])}{$site_base_url}{$data[$field->getField()]|ltrim:'/'|escape:'html'}{/if}</span></td>
    </tr>{/if}</tbody></table>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $('#{$field->getFieldHtmlID()}_hidden').rules('add', {$field->getRulesJSON()});
            $('#{$field->getFieldHtmlID()}').uploadify({
                'swf': '{$site_base_url}public/swf/uploadify.swf',
                'uploader': '{createUri controller="admin_editor" action="file_upload" params=[$sql_table]}',
                'method': 'post',
                'formData': { 'field': '{$field->getField()}', 'parent_id' : '{$parent_id}' },
                'queueID': '{$field->getFieldHtmlID()}_queue',
                'progressData': 'speed',
                'queueSizeLimit': 1,
                'buttonText': 'Vyber súbor',
                'multi': false,
                'fileSizeLimit': '{$field->getMaxSize()}',
                'fileTypeExts': '{$field->getAllowedTypes()}',
                'onUploadSuccess': function(file, data, response) {
                    var trimeddata = $.trim(data);
                    if (trimeddata.substring(0, 4) == '!OK!') {
                        if ($('#{$field->getFieldHtmlID()}_hidden').val() != '') {
                            $('#{$field->getFieldHtmlID()}_delete_files').val($('#{$field->getFieldHtmlID()}_delete_files').val() + '|' + $('#{$field->getFieldHtmlID()}_hidden').val());
                        }
                        $('#{$field->getFieldHtmlID()}_hidden').val(trimeddata.substring(4));
                        var download_link = '<a href="{$site_base_url}' + trimeddata.substring(4) + '" target="_blank">Stiahnuť</a>';
                        $('#{$field->getFieldHtmlID()}_download').html(download_link);
                        $('#{$field->getFieldHtmlID()}_delete button').css('display', '');
                        {if $field->getShowFilePath()}
                        $('#{$field->getFieldHtmlID()}_path_to_file').text('{$site_base_url}' + trimeddata.substring(4));
                        {/if}
                        update_link_{$field->getFieldHtmlID()}();
                        highlightChange();
                    } else {
                        alert('Chyba: ' + trimeddata);
                    }
                }
            });
            $('#{$field->getFieldHtmlID()}_delete button').click(function(){
                if ($('#{$field->getFieldHtmlID()}_hidden').val() != '') {
                    $('#{$field->getFieldHtmlID()}_delete_files').val($('#{$field->getFieldHtmlID()}_delete_files').val() + '|' + $('#{$field->getFieldHtmlID()}_hidden').val());
                }
                $('#{$field->getFieldHtmlID()}_hidden').val('');
                $('#{$field->getFieldHtmlID()}_download').html('');
                $('#{$field->getFieldHtmlID()}_delete button').css('display', 'none');
                alert('Súbor bude vymazaný až po uložení záznamu.');
            });
            
            function update_link_{$field->getFieldHtmlID()}() {
                {if $field->getUseFancybox()}
                    $('#{$field->getFieldHtmlID()}_download a').fancybox({
                        transitionIn: 'elastic',
                        transitionOut: 'elastic',
                        showNavArrows: false
                    }).text('Zobraziť');
                {/if}
            }
            
            update_link_{$field->getFieldHtmlID()}();
        });
    </script>
</div>