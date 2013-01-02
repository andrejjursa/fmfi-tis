{extends file='layouts/backend.tpl'}

{block content}
    {if $error}
        {include file='partials/admin_editor.index.errors.tpl' error=$error inline}
    {elseif $success}
        {include file='partials/admin_editor.success_msg.tpl' message='Záznam bol vymazaný.'}
    {/if}
{/block}