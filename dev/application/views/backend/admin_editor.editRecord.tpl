{extends file='layouts/backend.tpl'}

{block content}
    <style type="text/css">{literal}
        label.error { color: red; }
        .mm_relation_container ul li { background-color: white; border: 1px solid silver; padding: 2px; margin: 1px 0; border-radius: 4px; }
        .mm_relation_container ul li.sortable-highlight { height: 20px; background-color: #D0FFA8; border: 2px solid black; }
    {/literal}</style>
    <div id="site_base_url" rel="{$site_base_url}"></div>
    {if !isset($error)}
        <form action="{createUri controller='admin_editor' action='saveRecord' params=[$sql_table]}" method="post" class="editor">
        <div id="top_line">
            <input type="submit" name="save" value="Uložiť" class="button" />
            <input type="submit" name="save_and_edit" value="Uložiť a ďalej upravovať" class="button" />
            <input type="button" onclick="window.location='{createUri controller='admin_editor' action='index' params=[$sql_table]}'" class="button" value="Naspäť" />
        </div>
        {include file='partials/admin_editor.editor.tabs.tpl' inline}
        <input type="hidden" name="row_id" value="{$id}" />
        </form>
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {/if}
{/block}