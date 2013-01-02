{$gridField->getName()}
{if $gridField->getSortable()}
<span class="sortBy" style="display: inline-block">
    <form action="{createUri controller='admin_editor' action='index' params=[$sql_table]}" method="post">
        <input type="hidden" name="paginate[page]" value="{$current_page}" />
        <input type="hidden" name="paginate[rows_per_page]" value="{$current_rows_per_page}" />
        <input type="hidden" name="sorting[by]" value="{$gridField->getField()}" />
        {if $smarty.post.sorting.direction eq 'DESC' and $smarty.post.sorting.by eq $gridField->getField()}
        <input type="hidden" name="sorting[direction]" value="ASC" />
        {else}
        <input type="hidden" name="sorting[direction]" value="DESC" />
        {/if}
        <input type="image"  src="{$site_base_url}public/images/ui/arrow_UpDown.png" />
    </form>
</span>
{/if}