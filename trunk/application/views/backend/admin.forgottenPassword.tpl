{extends file='layouts/backend_login.tpl'}

{block name="content"}
<fieldset id="loginbox">
    <legend>Zabudnuté heslo</legend>
    {if $login_error}<div class="loginTableWrap">
        {include file='partials/admin_editor.error_msg.tpl' message='Nesprávny e-mail.' inline}
    </div>{/if}
    
    <p>Zadajte Emailovu adresu ktorú používate na prihlasovanie.</p>
    <p>Na túto adresu vám príde potvrdzujúci mail. Pokračujte pokynmi v maily.</p>
    
    <form action="{createUri controller='admin' action='send_password_request' params=''}" method="post">
        <div class="loginTableWrap">
            <table class="loginTable"><tbody>
                <tr>
                    <td class="label"><label>E-mail:</label></td>
                    <td><input type="text" maxlength="50" name="email" id="email_id" size="30" value="{$smarty.post.email|escape:'html'}" /></td>
                </tr>
                <tr>
                    <td colspan="2" class="error">{form_error field='email' prewrap='<span class="error">' postwrap='</span>'}</td>
                </tr>
                <tr>
                    <td colspan="2" class="button">
                        <button type="button" name="goback" onclick="window.location='{createUri controller='admin' action='login' params=[]}'">Naspäť</button>
                        <button type="submit" name="login" id="login_id" value="true">Obnoviť heslo</button>
                    </td>
                </tr>
            </tbody></table>
        </div>
    </form>
</fieldset>
{/block}