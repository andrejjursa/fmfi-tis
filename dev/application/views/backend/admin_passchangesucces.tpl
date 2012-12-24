{extends file='layouts/backend_login.tpl'}

{block name="content"}
<div>
  Vaše heslo bolo úspešne zmenené. Pokračujte prihlásením 
  <a href="{createUri controller='admin' action='login' params='' }">tu</a>.
     
</div>

{/block}