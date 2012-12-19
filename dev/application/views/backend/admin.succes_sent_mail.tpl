{extends file='layouts/backend_login.tpl'}

{block name="content"}
<div>
  Na vašu adresu bol zaslaný mail s inštrukciami na získanie nového hesla, pokračujte kliknutím na linku vo vašom maily.<br/>
  Môžete sa vrátiť na hlavnú stránku kliknutím <a href="{createUri controller='Timeline' action='index' params='' }">sem</a>
  alebo sa môžete vrátiť na prihlasovaciu stránku kliknutím <a href="{createUri controller='admin' action='login' params='' }">sem</a>.
</div>

{/block}