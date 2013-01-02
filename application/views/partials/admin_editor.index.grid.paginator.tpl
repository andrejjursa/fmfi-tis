<div id="paginator">
    <form action="{createUri controller='admin_editor' action='index' params=[$sql_table]}" method="post">
        {*<input type="hidden" name="paginate[page]" value="{$current_page}" />
        <input type="hidden" name="paginate[rows_per_page]" value="{$current_rows_per_page}" />*}
        <input type="hidden" name="sorting[by]" value="{$smarty.post.sorting.by}" />
        <input type="hidden" name="sorting[direction]" value="{$smarty.post.sorting.direction}" />
        Strana: <select name="paginate[page]" size="1">
            {for $page=1 to $max_pages}
            <option value="{$page}"{if $page eq $current_page} selected="selected"{/if}>{$page}. strana</option>
            {/for}
        </select>, počet záznamov na stranu: <select name="paginate[rows_per_page]" size="1">{$foundone = FALSE}
            {foreach $rows_per_pages_options as $option}
            {if $option eq $current_rows_per_page}{$selected = ' selected="selected"'}{$foundone = TRUE}{else}{$selected = ''}{/if}
            <option value="{$option|intval}"{$selected}>{$option|intval}</option>
            {/foreach}
            {if !$foundone}
            <option value="{$current_rows_per_page|intval}" selected="selected">{$current_rows_per_page|intval}</option>
            {/if}
        </select> <input type="submit" value="Aplikovať" />
    </form>
</div>