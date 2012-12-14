{if $error eq 'no_table'}
    {include file='partials/admin_editor.error_msg.tpl' message='Nebola vybraná žiadna existujúca tabuľka.'}
{elseif $error eq 'no_field'}
    {include file='partials/admin_editor.error_msg.tpl' message='Požadovaná položka sa nedá nájsť.'}
{elseif $error eq 'disabled'}
    {include file='partials/admin_editor.error_msg.tpl' message='Táto tabuľka sa nedá zobraziť v tomto režime.'}
{elseif $error eq 'no_new_record'}
    {include file='partials/admin_editor.error_msg.tpl' message='Táto tabuľka nemá povolené vytvárať nové záznamy.'}
{elseif $error eq 'no_edit_record'}
    {include file='partials/admin_editor.error_msg.tpl' message='Táto tabuľka nemá povolené upravovať existujúce záznamy.'}
{elseif $error eq 'cannot_save_data'}
    {include file='partials/admin_editor.error_msg.tpl' message='Nepodarilo sa uložiť dáta.'}
{elseif $error eq 'unknown_record'}
    {include file='partials/admin_editor.error_msg.tpl' message='Nepodarilo sa nájsť záznam.'}
{elseif $error eq 'no_delete_record'}
    {include file='partials/admin_editor.error_msg.tpl' message='Táto tabuľka nemá povolené vymazávať existujúce záznamy.'}
{elseif $error eq 'cant_delete_data'}
    {include file='partials/admin_editor.error_msg.tpl' message='Nie je možné vymazať neexistujúci záznam.'}
{elseif $error eq 'no_preview_record'}
    {include file='partials/admin_editor.error_msg.tpl' message='Táto tabuľka nemá povolené náhľady na záznamy.'}
{/if}
