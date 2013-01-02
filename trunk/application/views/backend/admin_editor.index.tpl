{extends file='layouts/backend.tpl'}

{block content}
    {if !isset($error)}
        {include file='partials/admin_editor.index.grid.tpl' 
            gridFields=$grid_settings.fields
            gridTableName=$grid_settings.table_name
            gridOperations=$grid_settings.operations inline}
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {/if}
{/block}