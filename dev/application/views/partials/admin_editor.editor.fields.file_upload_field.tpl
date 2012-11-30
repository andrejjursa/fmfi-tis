<div id="text_field_{$field->getField()}" class="highlight_field editor_field_line">
    <label for="{$field->getFieldHtmlID()}" title="{$field->getFieldHint()}">{$field->getFieldLabel()}:</label> <span id="{$field->getFieldHtmlID()}_download">{if $smarty.post.data[$field->getField()]|default:$data[$field->getField()]}<a href="{$site_base_url}{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]}" target="_blank">Stiahnuť</a>{/if}</span> <span id="{$field->getFieldHtmlID()}_delete"><button type="button" style="{{if $smarty.post.data[$field->getField()]|default:$data[$field->getField()]}}{else}display: none;{/if}">Vymazať</button></span>
    <input type="file" name="uploader_{$field->getField()}" value="" id="{$field->getFieldHtmlID()}" />
    <div id="{$field->getFieldHtmlID()}_queue"></div>
    <input type="hidden" name="data[{$field->getField()}]" value="{$smarty.post.data[$field->getField()]|default:$data[$field->getField()]|escape:'html'}" id="{$field->getFieldHtmlID()}_hidden" />
    <div class="error_container"></div>
    <input type="hidden" name="delete_files[{$field->getField()}]" value="" id="{$field->getFieldHtmlID()}_delete_files" />
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
                    if (data.substring(0, 4) == '!OK!') {
                        if ($('#{$field->getFieldHtmlID()}_hidden').val() != '') {
                            $('#{$field->getFieldHtmlID()}_delete_files').val($('#{$field->getFieldHtmlID()}_delete_files').val() + '|' + $('#{$field->getFieldHtmlID()}_hidden').val());
                        }
                        $('#{$field->getFieldHtmlID()}_hidden').val(data.substring(4));
                        var download_link = '<a href="{$site_base_url}' + data.substring(4) + '" target="_blank">Stiahnuť</a>';
                        $('#{$field->getFieldHtmlID()}_download').html(download_link);
                        $('#{$field->getFieldHtmlID()}_delete button').css('display', '');
                    } else {
                        alert('Chyba: ' + data);
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
            });
        });
    </script>
</div>