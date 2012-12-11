{extends file='layouts/backend_login.tpl'}

{block name="content"}
<h2>Zabudnuté heslo...</h2>
{if $login_error}
    {include file='partials/admin_editor.error_msg.tpl' message='Nesprávny e-mail.' inline}
{/if}
<div>
  Zadajte Emailovu adresu ktorú používate na prihlasovanie.
  <br/>
  Na túto adresu vám príde potvrdzujúci mail. Pokračujte pokynmi v maily.
</div>
<form method="post" action="{createUri controller='admin' action='send_password_request' params=''}">
    <label for="meno">Email:</label>
    <input type="text" maxlength="50" name="email" id="email_id" size="30" value="{$smarty.post.email|escape:'html'}" /> {form_error field='email' prewrap='<span class="error">' postwrap='</span>'}<br/>
    <button type="submit" name="login" id="login_id" value="true">Odošli</button>
</form>
{/block}