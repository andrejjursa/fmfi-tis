{if $parent_table eq $field->getParentTable() and $parent_id}
<input type="hidden" value="{$data[$field->getField()]|default:$parent_id}" name="data[{$field->getField()}]" />
{else}
    {if !is_null($field->getElseField())}
        {$field_type = $field->getElseField()->getFieldType()}
        {include file="partials/admin_editor.editor.fields.$field_type.tpl" field=$field->getElseField() inline}
    {else}
        {include file='partials/admin_editor.error_msg.tpl' message='Nedá sa nájsť rodičovský záznam a nie je nastavená alternatíva pre jeho získanie.' inline}
    {/if}
{/if}