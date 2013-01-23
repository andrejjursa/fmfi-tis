{extends file='layouts/install.tpl'}

{block content}
<p>Prosím, vyplňte konfiguračné položky tohoto formulára.</p>
<p>Ak použijete na doručovanie e-mailov protokol SMTP, pravdepodobne budete musieť vyplniť aj názov hosta, port, používateľa a heslo.</p>
<form action="{$site_base_url}/index.php/install/save_config" method="post" autocomplete="off">
<table class="installtable"><tbody>
    <tr>
        <td class="label"><label for="config_application_rewrite_enabled_id">Zapnúť rewrite engine pre frontend:</label></td>
        <td class="data"><select name="config[application][rewrite_enabled]" id="config_application_rewrite_enabled_id" size="1">
            {html_options options=[0 => 'Vypnúť', 1 => 'Zapnúť'] selected=$smarty.post.config.application.rewrite_enabled}
        </select></td>
        <td class="error">{form_error field='config[application][rewrite_enabled]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_protocol_id">E-mailový protokol:</label></td>
        <td class="data"><select name="config[application][email][protocol]" id="config_application_email_protocol_id" size="1">
            {html_options options=['mail' => 'Základná funkcionalita PHP (funkcia mail())', 'smtp' => 'Použiť SMTP (Simple mail transfer protocol)'] selected=$smarty.post.config.application.email.protocol}
        </select></td>
        <td class="error">{form_error field='config[application][email][protocol]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_smtp_host_id">SMTP Host:</label></td>
        <td class="data"><input type="text" name="config[application][email][smtp_host]" value="{$smarty.post.config.application.email.smtp_host|escape:'html'}" id="config_application_email_smtp_host_id" /></td>
        <td class="error">{form_error field='config[application][email][smtp_host]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_smtp_port_id">SMTP Port:</label></td>
        <td class="data"><input type="text" name="config[application][email][smtp_port]" value="{$smarty.post.config.application.email.smtp_port|escape:'html'}" id="config_application_email_smtp_port_id" /></td>
        <td class="error">{form_error field='config[application][email][smtp_port]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_smtp_user_id">SMTP Používateľ:</label></td>
        <td class="data"><input type="text" name="config[application][email][smtp_user]" value="{$smarty.post.config.application.email.smtp_user|escape:'html'}" id="config_application_email_smtp_user_id" /></td>
        <td class="error">{form_error field='config[application][email][smtp_user]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_smtp_pass_id">SMTP Heslo:</label></td>
        <td class="data"><input type="text" name="config[application][email][smtp_pass]" value="{$smarty.post.config.application.email.smtp_pass|escape:'html'}" id="config_application_email_smtp_pass_id" /></td>
        <td class="error">{form_error field='config[application][email][smtp_pass]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_from_id">Adresa odchádzajúcej pošty:</label></td>
        <td class="data"><input type="text" name="config[application][email_from]" value="{$smarty.post.config.application.email_from|escape:'html'}" id="config_application_email_from_id" /></td>
        <td class="error">{form_error field='config[application][email_from]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="config_application_email_from_name_id">Meno adresy odchádzajúcej pošty:</label></td>
        <td class="data"><input type="text" name="config[application][email_from_name]" value="{$smarty.post.config.application.email_from_name|escape:'html'}" id="config_application_email_from_name_id" /></td>
        <td class="error">{form_error field='config[application][email_from_name]' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
    <tr>
        <td class="label"><label for="test_email_id">Adresa kam poslať testovací e-mail:</label></td>
        <td class="data"><input type="text" name="test_email" value="{$smarty.post.test_email|escape:'html'}" id="test_email_id" /></td>
        <td class="error">{form_error field='test_email' prewrap='<div class="error">' postwrap='</div>'}</td>
    </tr>
</tbody></table>
<input type="submit" value="Nastaviť hodnoty konfigurácie" class="button" />
</form>
{/block}