<table id="editor_grid_table" style="width: 100%;">
    <thead>
        <tr>
        {foreach $gridFields as $gridField}
            <th style="text-align: left;">
                {include file='partials/admin_editor.index.grid.headerField.tpl' gridField=$gridField inline}
            </th>
        {/foreach}
            <th>Operácie</th>
        </tr>
    </thead>
    <tbody>
        {foreach $rows as $row}
        <tr class="{cycle values='grid_row_light,grid_row_dark'}">
            {foreach $gridFields as $gridField}
            <td>
                {include file='partials/admin_editor.index.grid.field.tpl' row=$row gridField=$gridField inline}    
            </td>
            {/foreach}
            <td>
            </td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="{$gridFields|count + 1}">
                <div class="error"><div class="error_message">Neboli nájdená žiadne záznamy.</div></div>
            </td>
        </tr>
        {/foreach}
    </tbody>
    <tfoot>
        <tr>
            <td colspan="{$gridFields|count + 1}">
            {include file='partials/admin_editor.index.grid.paginator.tpl' inline}
            </td>
        </tr>
    </tfoot>
</table>