{if $notabs eq 1}
<div id="editor_items">
    {foreach $editor_settings.tabs as $tab}
    <fieldset class="editor_item">
    <legend class="editor_item">{$tab->getName()}</legend>
    {include file='partials/admin_editor.editor.fields.tpl' tab=$tab inline}
    </fieldset>
    {/foreach}
</div>
{else}
<div id="editor_tabs">
    <ul id="editor_tabs_labels">
    {$i = 1}
    {foreach $editor_settings.tabs as $tab}
        <li><a href="#editor_tabs-tab{$i}">{$tab->getName()}</a></li>{$i = $i + 1}
    {/foreach}
    </ul>
    {$i = 1}
    {foreach $editor_settings.tabs as $tab}
        <div id="editor_tabs-tab{$i}">
        {include file='partials/admin_editor.editor.fields.tpl' tab=$tab inline}
        </div>{$i = $i + 1}
    {/foreach}
</div>
{/if}