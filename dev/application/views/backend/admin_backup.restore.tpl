{extends file='layouts/backend.tpl'}

{block content}
<h1>Obnova aplikácie</h1>
<div id="dbackup">
<p>
	Tu môžete obnoviť aplikáciu zo zálohového súboru.
</p>
{if $result eq "ok"}
	<span style="font-size: 150%; color: red">Aplikácia bola úspešne obnovená</span>
{/if}
{if $result eq "error"}
	<span style="font-size: 150%; color: red">Neplatný súbor zálohy</span>
{/if}
<form action="{createUri controller="admin_backup" action="restore"}" enctype="multipart/form-data" method="post">
	<div>
		<input type="file" name="file" />
		<input type="submit" value="Obnoviť" />
	</div>
</form>
<h2>Obnoviť zo zálohy</h2>
<ol>
{foreach $backups as $backup}
	<li><a href="{createUri controller="admin_backup" action="restore" params=[$backup]}">{$backup}</a></li>
{/foreach}
</ol>
</div>
{/block}