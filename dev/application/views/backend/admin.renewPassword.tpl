{extends file='layouts/backend_login.tpl'}

{block name="content"}
<fieldset id="loginbox">
    <legend>Zabudnuté heslo</legend>
    {if $pass_error}<div class="loginTableWrap">
        {include file='partials/admin_editor.error_msg.tpl' message='Heslá sa nezhodujú.' inline}
    </div>{/if}
    
    <p>Zadajte nové heslo pre váš účet.</p>
    <form method="post" action="{createUri controller='admin' action='do_renew_password' params=''}">
        <div class="loginTableWrap">
            <table class="loginTable"><tbody>
                <tr>
                    <td class="label"><label for="pass">Nové Heslo:</label></td>
                    <td><input type="password" maxlength="30" name="pass" id="password_id" size="30" value="{$smarty.post.pass|escape:'html'}" /></td>
                </tr>
                <tr>
                    <td colspan="2" class="error">{form_error field='pass' prewrap='<span class="error">' postwrap='</span>'}</td>
                </tr>
                <tr>
                    <td class="label"><label for="npass">Potvrdenie:</label></td>
                    <td><input type="password" maxlength="30" name="npass" id="password_id" size="30" value="{$smarty.post.npass|escape:'html'}" /></td>
                </tr>
                <tr>
                    <td colspan="2" class="error">{form_error field='npass' prewrap='<span class="error">' postwrap='</span>'}</td>
                </tr>
                <tr>
                    <td colspan="2" class="button">
                        <button type="button" name="goback" onclick="window.location='{createUri controller='admin' action='login' params=[]}'">Naspäť na prihlásenie</button>
                        <button type="submit" name="login" id="login_id" value="true">Odošli</button>
                    </td>
                </tr>
            </tbody></table>
        </div>
        <input type="hidden" name="id" value="{$id}"/>
        <input type="hidden" name="token" value="{$token}"/>
    </form>
</fieldset>
{*
<h2>Zabudnuté heslo...</h2>
{if $pass_error}
    {include file='partials/admin_editor.error_msg.tpl' message='Nesprávne heslá.' inline}
{/if}
<div>
  Zadajte nové heslo pre váš účet.
</div>
<form method="post" action="{createUri controller='admin' action='do_renew_password' params=''}">
    <label for="pass">Nové Heslo:</label>
    <input type="password" maxlength="30" name="pass" id="password_id" size="30" value="{$smarty.post.pass|escape:'html'}" /> {form_error field='pass' prewrap='<span class="error">' postwrap='</span>'}<br/>
    <label for="npass">Potvrdenie Hesla:</label>
    <input type="password" maxlength="30" name="npass" id="password_id" size="30" value="{$smarty.post.npass|escape:'html'}" /> {form_error field='npass' prewrap='<span class="error">' postwrap='</span>'}<br/>
    <input type="hidden" name="id" value="{$id}"/>
    <input type="hidden" name="token" value="{$token}"/>
    <button type="submit" name="login" id="login_id" value="true">Odošli</button>

</form>
*}
{/block}