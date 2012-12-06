{extends file='layouts/backend_iframe.tpl'}

{block content}
    <style type="text/css">{literal}
        body { background-color: white; }
        label.error { color: red; }
        .mm_relation_container ul li { background-color: white; border: 1px solid silver; padding: 2px; margin: 1px 0; border-radius: 4px; }
        .mm_relation_container ul li.sortable-highlight { height: 20px; background-color: #D0FFA8; border: 2px solid black; }
        #editor_items fieldset.editor_item { border: 1px solid silver; border-radius: 4px; margin-top: 10px; }
        #editor_items fieldset.editor_item legend.editor_item { border: 1px solid silver; border-radius: 4px; padding: 4px 10px; font-size: 1.5em; }
    {/literal}</style>
    <div id="site_base_url" rel="{$site_base_url}"></div>
    {if !isset($error)}
        <form action="{createUri controller='admin_editor' action='saveRecord' params=[$sql_table]}" method="post" class="editor displayErrors">
        <div id="top_line">
            <input type="submit" name="save_and_iframe" value="Uložiť" class="button" />
        </div>
        {include file='partials/admin_editor.editor.tabs.tpl' notabs=1 inline}
        <input type="hidden" name="row_id" value="{$id}" />
        <input type="hidden" name="parent_id" value="{$parent_id}" />
        <input type="hidden" name="parent_table" value="{$parent_table}" />
        </form>
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {/if}
{/block}