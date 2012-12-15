{extends file='layouts/backend.tpl'}

{block content}
    <div id="site_base_url" rel="{$site_base_url}"></div>
    {if !isset($error)}
        <form action="{createUri controller='admin_editor' action='saveRecord' params=[$sql_table]}" method="post" class="editor">
        <div id="top_line">
            <input type="submit" name="save" value="Uložiť" class="button" />
            <input type="submit" name="save_and_edit" value="Uložiť a ďalej upravovať" class="button" />
            <input type="button" onclick="window.location='{createUri controller='admin_editor' action='index' params=[$sql_table]}'" class="button" value="Naspäť" />
        </div>
        {include file='partials/admin_editor.editor.tabs.tpl' notabs=0 inline}
        </form>
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {/if}
{/block}