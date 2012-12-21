{if is_array($flash_message)}
{if $flash_message.type eq 'success'}
{include file='partials/admin_editor.success_msg.tpl' message=$flash_message.message}
{else}
{include file='partials/admin_editor.error_msg.tpl' message=$flash_message.message}
{/if}
{/if}