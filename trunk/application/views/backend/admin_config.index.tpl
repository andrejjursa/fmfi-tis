{extends file='layouts/backend.tpl'}

{block name='content'}
<h2>Nastavenia aplikácie</h2>
<form action="{createUri controller='admin_config' action='save'}" method="post">
    <div class="config_controlls">
        <input type="submit" value="Uložiť" class="button" />
        <input type="reset" value="Obnoviť pôvodné hodnoty" class="button" />
        <input type="button" value="Otestovať e-mail" class="button" id="test_email_button_id" title="Ak ste vykonali zmeny v nastavení e-mailu, najprv zmeny uložte tlačidlom Uložiť." />
    </div>
    {include file='partials/admin.flash_message.tpl'}
    <fieldset class="config">
        <legend>Všeobecné nastavenia</legend>
        <table class="config_table"><tbody>
            <tr>
                <td class="label"><label for="config_application_rewrite_enabled_id" title="Zapnutý rewrite engine vytvorí na frontende odkazy bez priameho volania súboru index.php.">Zapnúť rewrite engine pre frontend:</label></td>
                <td><select name="config[application][rewrite_enabled]" id="config_application_rewrite_enabled_id" size="1" class="width_100pr">
                    {html_options options=[0 => 'Vypnúť', 1 => 'Zapnúť'] selected=$smarty.post.config.application.rewrite_enabled|default:$config.application.rewrite_enabled}
                </select></td>
                <td class="error">{form_error field='config[application][rewrite_enabled]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_config_encryption_key_id" title="Bezpečnostný kľúč slúži na zabespečenie sessions, po jeho úprave budú všetky sessions zneplatnené a každý používateľ odhlásený. Musí byť nastavené plné 32 miestne slovo.">Bezpečnostný kryptovací kľúč:</label></td>
                <td><input type="text" maxlength="32" name="config[config][encryption_key]" value="{$smarty.post.config.config.encryption_key|default:$config.config.encryption_key|escape:'html'}" size="32" id="config_config_encryption_key_id" class="width_100pr" /> <input type="button" value="Vygenerovať kľúč" id="config_config_encryption_key_generator_id" /></td>
                <td class="error">{form_error field='config[config][encryption_key]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
        </tbody></table>
    </fieldset>
    <fieldset class="config">
        <legend>E-mailové nastavenia</legend>
        <table class="config_table"><tbody>
            <tr>
                <td class="label"><label for="config_application_email_protocol_id" title="Vyberte spôsob, akým sa budú odosielať e-maily. V prípade výberu SMTP bude pravdepodobne nutné zadať prihlasovacie údaje pre smtp server.">Spôsob odosielania e-mailov:</label></td>
                <td><select name="config[application][email][protocol]" id="config_application_email_protocol_id" size="1" class="width_100pr">
                    {html_options options=['mail' => 'Základná funkcionalita PHP (funkcia mail())', 'smtp' => 'Použiť SMTP (Simple mail transfer protocol)'] selected=$smarty.post.config.application.email.protocol|default:$config.application.email.protocol}
                </select></td>
                <td class="error">{form_error field='config[application][email][protocol]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_application_email_smtp_host_id" title="Adresa hostu smtp servera, nutné zadať pre odosielanie e-mailov pomocou SMTP protokolu.">SMTP Host:</label></td>
                <td><input type="text" name="config[application][email][smtp_host]" id="config_application_email_smtp_host_id" value="{$smarty.post.config.application.email.smtp_host|default:$config.application.email.smtp_host|escape:'html'}" class="width_100pr" /></td>
                <td class="error">{form_error field='config[application][email][smtp_host]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_application_email_smtp_port_id" title="Port, na ktorom počúva smtp server, pravdepodobne nutné zadať pre odosielanie e-mailov pomocou SMTP protokolu.">SMTP Port:</label></td>
                <td><input type="text" name="config[application][email][smtp_port]" id="config_application_email_smtp_port_id" value="{$smarty.post.config.application.email.smtp_port|default:$config.application.email.smtp_port|escape:'html'}" class="width_100pr" /></td>
                <td class="error">{form_error field='config[application][email][smtp_port]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_application_email_smtp_user_id" title="Meno používateľa na prihlásenie sa na smtp server, pravdepodobne nutné zadať pre odosielanie e-mailov pomocou SMTP protokolu.">SMTP Meno používateľa:</label></td>
                <td><input type="text" name="config[application][email][smtp_user]" id="config_application_email_smtp_user_id" value="{$smarty.post.config.application.email.smtp_user|default:$config.application.email.smtp_user|escape:'html'}" class="width_100pr" /></td>
                <td class="error">{form_error field='config[application][email][smtp_user]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_application_email_smtp_pass_id" title="Heslo používateľa na prihlásenie sa na smtp server, pravdepodobne nutné zadať pre odosielanie e-mailov pomocou SMTP protokolu.">SMTP Heslo:</label></td>
                <td><input type="text" name="config[application][email][smtp_pass]" id="config_application_email_smtp_pass_id" value="{$smarty.post.config.application.email.smtp_pass|default:$config.application.email.smtp_pass|escape:'html'}" class="width_100pr" /></td>
                <td class="error">{form_error field='config[application][email][smtp_pass]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_application_email_from_id" title="Nastavte e-mailovú adresu pre odchádzajúcu poštu. Niektoré e-mailové servery môžu vyžadovať, aby táto adresa skutočne existovala.">E-mailová adresa odchádzajúcej pošty:</label></td>
                <td><input type="text" name="config[application][email_from]" id="config_application_email_from_id" value="{$smarty.post.config.application.email_from|default:$config.application.email_from|escape:'html'}" class="width_100pr" /></td>
                <td class="error">{form_error field='config[application][email_from]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
            <tr>
                <td class="label"><label for="config_application_email_from_name_id" title="Zadajte meno vlastníka e-mailovej adresy pre odchádzajúcu poštu.">Pomenujte e-mailovú adresu odchádzajúcej pošty:</label></td>
                <td><input type="text" name="config[application][email_from_name]" id="config_application_email_from_name_id" value="{$smarty.post.config.application.email_from_name|default:$config.application.email_from_name|escape:'html'}" class="width_100pr" /></td>
                <td class="error">{form_error field='config[application][email_from_name]' prewrap='<span>' postwrap='</span>'}</td>
            </tr>
        </tbody></table>
    </fieldset>
</form>
{/block}