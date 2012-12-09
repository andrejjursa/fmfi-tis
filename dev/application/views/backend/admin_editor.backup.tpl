{extends file='layouts/backend.tpl'}

{block content}
<h1>Záloha</h1>
<p>
Tu môžete vytvoriť zálohu celej aplikácie, s ktorou môžete neskôr aplikáciu obnoviť.
</p>
<ol>
	<li>Vytvorte zálohu a stiahnite súbor do svojho počítača</li>
</ol>
<p>
<a href="{createUri controller="admin_editor" action="make_backup"}">Vytvoriť zálohu</a>
</p>
{/block}