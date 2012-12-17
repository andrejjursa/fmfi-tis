{extends file='layouts/backend.tpl'}

{block content}
<h1>Obnova aplikácie</h1>
<div id="dbackup">

    <fieldset class="logs">
        <legend>Tu môžete obnoviť aplikáciu zo zálohového súboru.</legend>
		
{if $result eq "ok"}
	<span style="font-size: 150%; color: red">Aplikácia bola úspešne obnovená</span>
{/if}
{if $result eq "error"}
	<span style="font-size: 150%; color: red">Neplatný súbor zálohy</span>
{/if}
		
		<form action="{createUri controller='admin_backup' action='restore'}" enctype="multipart/form-data" method="post">
		<div class="row">
            <div class="label">Obnoviť zo súboru:</div>
            <div class="content"><input type="file" name="file" /><input type="submit" value="Obnoviť" /></div>
        </div>
		</form>
		<br />
        <div class="row">
            <div class="label">Obnoviť zo zálohy:</div>
			{foreach $backups as $backup}
            <div class="content"><a href="{createUri controller='admin_backup' action='restore' params=[$backup]}">{$backup}</a></div>
			{foreachelse}
			<div class="content">Žiadne zálohy nie sú dostupné.</div>
			{/foreach}
        </div>
    </fieldset>



</div>
{/block}