{if !isset($error)}
    <ul style="min-height: 20px; padding: 10px; border: 1px solid black; list-style-type: none;">
        {foreach $rows as $row}
        <li row_id="{$row->getId()}">
            <table style="width: 100%; border-collapse: collapse;">
            <tbody><tr>
                {foreach $gridFields as $gridField}
                    <td style="width: {$gridField->getWidth()};">{include file='partials/admin_editor.index.grid.field.tpl' row=$row gridField=$gridField inline}</td>
                {/foreach}
            </tr></tbody>
            </table>
        </li>
        {/foreach}
    </ul>
{else}
    {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
{/if}