{extends file='layouts/backend_login.tpl'}
{block name="content"}
{if $login_error}
    {include file='partials/admin_editor.error_msg.tpl' message='Nesprávny e-mail alebo heslo.' inline}
{/if}

<h2>Prihláste sa prosím...</h2>
<form method="post" action="{createUri controller='admin' action='do_login' params=''}" id="flogin">
    <label for="meno">Email:</label>
    <input type="text" maxlength="50" name="email" id="email_id" size="30" value="{$smarty.post.email|escape:'html'}" /> {form_error field='email' prewrap='<span class="error">' postwrap='</span>'}<br/>
    <label for="pass">Heslo:</label>
    <input type="password" maxlength="30" name="password" id="password_id" size="30" value="{$smarty.post.password|escape:'html'}" /> {form_error field='password' prewrap='<span class="error">' postwrap='</span>'}<br/>
    <button type="submit" name="login" id="login_id" value="true">Prihlás ma</button>
</form>
<form method="post" action="{createUri controller='admin' action='forgotten_password' params=''}">
    <button type="submit" name="reset" value="true">Zabudol si heslo?</button>
</form>
{/block}