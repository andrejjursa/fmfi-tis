{extends file='layouts/backend.tpl'}

{block content}
<h1>Záloha</h1>
<div id="dbackup">
<p>
Tu môžete vytvoriť zálohu celej aplikácie, s ktorou môžete neskôr aplikáciu obnoviť.
</p>
<p>
<a href="{createUri controller="admin_backup" action="make_backup"}">Vytvoriť zálohu</a>
</p>
<h2>Dostupné zálohy</h2>
<ol>
{foreach $backups as $backup}
	<li><a href="{createUri controller="admin_backup" action="download" params=[$backup]}">{$backup}</a></li>
{/foreach}
</ol>
</div>
{/block}