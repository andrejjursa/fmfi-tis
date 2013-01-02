{extends file='layouts/backend_login.tpl'}

{block name="content"}
<fieldset id="loginbox">
    <legend>Zabudnuté heslo</legend>
    <div class="loginTableWrap">
        Vaše heslo bolo úspešne zmenené. Pokračujte prihlásením 
        <a href="{createUri controller='admin' action='login' params='' }">tu</a>.
    </div>
</fieldset>
{/block}