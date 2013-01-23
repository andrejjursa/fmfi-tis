{extends file='layouts/install.tpl'}

{block content}
<p>Prosím, vložte potrebné údaje pre pripojenie k databáze MySQL. Do poľa hostiteľ môžete za dvojbodku zadať port ak je to potrebné.</p>
<form action="{$site_base_url}/index.php/install/make_database" method="post" autocomplete="off">
<table class="installtable"><tbody>
    <tr>
        <td class="label"><label for="db_hostname_id">Hostiteľ:</label></td>
        <td class="data"><input type="text" name="db[hostname]" value="{$smarty.post.db.hostname|escape:'html'}" id="db_hostname_id" /></td>
        <td class="error">{form_error field='db[hostname]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="db_username_id">Meno používateľa:</label></td>
        <td class="data"><input type="text" name="db[username]" value="{$smarty.post.db.username|escape:'html'}" id="db_username_id" /></td>
        <td class="error">{form_error field='db[username]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="db_password_id">Heslo:</label></td>
        <td class="data"><input type="password" name="db[password]" value="{$smarty.post.db.password|escape:'html'}" id="db_password_id" /></td>
        <td class="error">{form_error field='db[password]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr> 
    <tr>
        <td class="label"><label for="db_database_id">Názov databázy:</label></td>
        <td class="data"><input type="text" name="db[database]" value="{$smarty.post.db.database|escape:'html'}" id="db_database_id" /></td>
        <td class="error">{form_error field='db[database]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
</tbody></table>
<input type="submit" value="Pripojiť sa a vytvoriť databázovú štruktúru" class="button" />
</form>
{/block}