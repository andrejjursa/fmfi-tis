{extends file='layouts/backend.tpl'}

{block content}
    {if !isset($error)}
        <pre>{$grid_settings|var_export:TRUE}</pre>
    {else}
        {include file='partials/admin_editor.index.errors.tpl' error=$error}
    {/if}
{/block}