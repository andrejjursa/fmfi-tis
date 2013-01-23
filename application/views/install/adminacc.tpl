{extends file='layouts/install.tpl'}

{block content}
<p>Prosím, vyplňte tento formulár. E-mail sa používa ako prihlasovacie meno.</p>
<form action="{$site_base_url}/index.php/install/make_adminacc" method="post" autocomplete="off">
<table class="installtable"><tbody>
    <tr>
        <td class="label"><label for="admin_email_id">E-mail:</label></td>
        <td class="data"><input type="text" name="admin[email]" value="{$smarty.post.admin.email|escape:'html'}" id="admin_email_id" /></td>
        <td class="error">{form_error field='admin[email]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="admin_email2_id">E-mail (kontrola):</label></td>
        <td class="data"><input type="text" name="admin[email2]" value="{$smarty.post.admin.email2|escape:'html'}" id="admin_email2_id" /></td>
        <td class="error">{form_error field='admin[email2]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="admin_password_id">Heslo:</label></td>
        <td class="data"><input type="password" name="admin[password]" value="{$smarty.post.admin.password|escape:'html'}" id="admin_password_id" /></td>
        <td class="error">{form_error field='admin[password]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr> 
    <tr>
        <td class="label"><label for="admin_password2_id">Heslo (kontrola):</label></td>
        <td class="data"><input type="password" name="admin[password2]" value="{$smarty.post.admin.password2|escape:'html'}" id="admin_password2_id" /></td>
        <td class="error">{form_error field='admin[password2]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
</tbody></table>
<input type="submit" value="Vytvoriť administrátorský účet" class="button" />
</form>
{/block}