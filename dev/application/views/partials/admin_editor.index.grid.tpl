<h2>{$gridTableName}</h2>
{if $gridOperations.new_record}
<div><a href="{createUri controller='admin_editor' action='newRecord' params=[$sql_table]}" class="button">{$gridOperations.new_record_title|default:'Nový záznam'}</a></div>
{/if}
<table id="editor_grid_table" style="width: 100%;">
    <thead>
        <tr>
        {foreach $gridFields as $gridField}
            <th style="text-align: left; width: {$gridField->getWidth()};">
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
            <td style="width: {$gridField->getWidth()};">
                {include file='partials/admin_editor.index.grid.field.tpl' row=$row gridField=$gridField inline}    
            </td>
            {/foreach}
            <td>
                {if $gridOperations.edit_record}
                <a href="{createUri controller='admin_editor' action='editRecord' params=[$sql_table, $row->getId()]}" class="button">{$gridOperations.edit_record_title|default:'Upraviť'}</a>
                {/if}
                {if $gridOperations.delete_record}
                <a href="{createUri controller='admin_editor' action='deleteRecord' params=[$sql_table, $row->getId()]}" class="button">{$gridOperations.delete_record_title|default:'Vymazať'}</a>
                {/if}
                {if $gridOperations.preview_record}
                <a href="{createUri controller='admin_editor' action='previewRecord' params=[$sql_table, $row->getId()]}" class="button" target="_blank" rel="fancybox_ajax">{$gridOperations.preview_record_title|default:'Náhlad'}</a>
                {/if}
            </td>
        </tr>
        {foreachelse}
        <tr>
            <td colspan="{$gridFields|count + 1}">
                <div class="ui-widget">
                	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                		<strong>Chyba:</strong> Neboli nájdená žiadne záznamy.</p>
                	</div>
                </div>
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