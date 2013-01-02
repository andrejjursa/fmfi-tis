{extends file='layouts/backend_login.tpl'}
{block name="content"}
<fieldset id="loginbox">
    <legend>Prihlásenie</legend>
    {if $login_error}<div class="loginTableWrap">
        {include file='partials/admin_editor.error_msg.tpl' message='Nesprávny e-mail alebo heslo.' inline}
    </div>{/if}
    
    <form action="{createUri controller='admin' action='do_login' params=''}" method="post">
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
                    <td class="label"><label>Heslo:</label></td>
                    <td><input type="password" maxlength="30" name="password" id="password_id" size="30" value="{$smarty.post.password|escape:'html'}" /></td>
                </tr>
                <tr>
                    <td colspan="2" class="error">{form_error field='password' prewrap='<span class="error">' postwrap='</span>'}</td>
                </tr>
                <tr>
                    <td colspan="2" class="button">
                        <button type="button" name="forgotten_password" onclick="window.location='{createUri controller='admin' action='forgotten_password' params=''}'">Zabudol som heslo</button>
                        <button type="submit" name="login" id="login_id" value="true">Prihlásiť sa</button>
                    </td>
                </tr>
            </tbody></table>
        </div>
    </form>
</fieldset>
{/block}