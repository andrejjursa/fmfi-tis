{extends file='layouts/backend_login.tpl'}

{block name="content"}
<fieldset id="loginbox">
    <legend>Zabudnuté heslo</legend>
    <div class="loginTableWrap">
        Link ktorý ste použili na obnovenie hesla bol už použitý. Pokial si prajete zaslať nový kliknite 
        <a href="{createUri controller='admin' action='forgotten_password' params='' }">sem</a>.
        Ak si prajete vrátiť sa na prihlasovaciu stránku kliknite  <a href="{createUri controller='admin' action='login' params='' }">sem</a>.
    </div>
</fieldset>

{/block}