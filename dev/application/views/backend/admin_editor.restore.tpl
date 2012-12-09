{extends file='layouts/backend.tpl'}

{block content}
<h1>Obnova aplikácie</h1>
<p>
	Tu môžete obnoviť aplikáciu zo zálohového súboru.
</p>
{if $result eq "ok"}
	<span style="font-size: 150%; color: red">Aplikácia bola úspešne obnovená</span>
{/if}
{if $result eq "error"}
	<span style="font-size: 150%; color: red">Neplatný súbor zálohy</span>
{/if}
<form action="{createUri controller="admin_editor" action="restore"}" enctype="multipart/form-data" method="post">
	<div>
		<input type="file" name="file" />
		<input type="submit" value="Obnoviť" />
	</div>
</form>
{/block}