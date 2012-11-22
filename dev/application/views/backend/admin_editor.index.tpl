{extends file='layouts/backend.tpl'}

{block content}
    <style type="text/css">{literal}
        #editor_grid_table { border: 1px solid black; border-collapse: collapse; }
        #editor_grid_table thead tr { background-color: silver; }
        #editor_grid_table tfoot tr { background-color: silver; text-align: right; }
        #editor_grid_table td { border: 1px solid black; }
        #editor_grid_table td, #editor_grid_table th { padding: 2px; }
        #editor_grid_table .bool_field .yes { color: green; }
        #editor_grid_table .bool_field .no { color: red; }
        tr.grid_row_light { background-color: #F8F8F8; }
        tr.grid_row_dark { background-color: #C4C4C4; }
    {/literal}</style>
    {if !isset($error)}
        {include file='partials/admin_editor.index.grid.tpl' gridFields=$grid_settings.fields inline}
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {/if}
{/block}