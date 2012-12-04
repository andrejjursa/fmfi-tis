{extends file='layouts/backend.tpl'}

{block name="content"}
<?php echo validation_errors(); ?>
{$error}
<form method="post" action="{createUri controller='Admin' action='do_login' params=''}">
  <label for="meno">Email:</label>
  <input type="text" maxlength="50" name="meno" id="meno" size="30" /><br/>
  <label for="pass">Heslo:</label>
  <input type="password" maxlength="30" name="pass" id="pass" size="30" /><br/>
  <button type="submit" name="log" id="log" value="true">Prihlás ma</button>
</form>
<form method="post" action="{createUri controller='Admin' action='forgotten_password' params=''}">
  <button type="submit" name="reset" value="true">Zabudol si heslo?</a>
</form>

{/block}