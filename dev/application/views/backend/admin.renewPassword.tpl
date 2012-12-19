{extends file='layouts/backend_login.tpl'}

{block name="content"}
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
{/block}