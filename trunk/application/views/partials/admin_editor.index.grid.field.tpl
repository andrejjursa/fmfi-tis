{$known_field_types = ['text', 'html', 'datetime', 'image', 'file', 'number', 'bool', 'smarty']}
{if in_array($gridField->getType(), $known_field_types)}
{capture assign='filename'}partials/admin_editor.index.grid.field.{$gridField->getType()}.tpl{/capture}
{include file=$filename row=$row gridField=$gridField inline}
{else}
{$row->data($gridField->getField())|escape:'html'}
{/if}