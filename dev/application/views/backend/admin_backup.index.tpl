{extends file='layouts/backend.tpl'}

{block content}
<h1>Záloha</h1>
<div id="dbackup">
    <fieldset class="logs">
        <legend>Tu môžete vytvoriť zálohu celej aplikácie, s ktorou môžete neskôr aplikáciu obnoviť.</legend>
		<div class="row">
            <div class="label">Vytvoriť zálohu:</div>
            <div class="content"><a href="{createUri controller='admin_backup' action='make_backup'}">Vytvoriť</a></div>
        </div>
		<br />
        <div class="row">
            <div class="label">Dostupné zálohy:</div>
			{foreach $backups as $backup}
            <div class="content"><a href="{createUri controller='admin_backup' action='download' params=[$backup]}">{$backup}</a></div>
			{foreachelse}
			<div class="content">Žiadne zálohy nie sú dostupné.</div>
			{/foreach}
        </div>
    </fieldset>

</div>
{/block}