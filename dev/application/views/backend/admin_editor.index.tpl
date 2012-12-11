{extends file='layouts/backend.tpl'}

{block content}
    <style type="text/css">{literal}
        #editor_grid_table { border: 1px solid black; border-collapse: collapse; }
        #editor_grid_table thead tr { background-color: #F8F8F8; }
        #editor_grid_table tfoot tr { background-color: silver; text-align: right; }
        #editor_grid_table td { border: 1px solid black; }
        #editor_grid_table td, #editor_grid_table th { padding: 2px; }
        #editor_grid_table .bool_field .yes { color: green; }
        #editor_grid_table .bool_field .no { color: red; }
        tr.grid_row_light,
        tr.grid_row_dark { 
            transition: all 0.2s ease-in-out;
            -moz-transition: all 0.2s ease-in-out;
            -o-transition: all 0.2s ease-in-out;
            -webkit-transition: all 0.2s ease-in-out;
            -ms-transition: all 0.2s ease-in-out;
        }
        tr.grid_row_light { background-color: #F8F8F8; }
        tr.grid_row_dark { background-color: #C4C4C4; }
        tr.grid_row_light:hover,
        tr.grid_row_dark:hover { background-color: #FFE586; }
    {/literal}</style>
    {if !isset($error)}
        {include file='partials/admin_editor.index.grid.tpl' 
            gridFields=$grid_settings.fields
            gridTableName=$grid_settings.table_name
            gridOperations=$grid_settings.operations inline}
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {/if}
{/block}