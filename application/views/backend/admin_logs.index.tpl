{extends file='layouts/backend.tpl'}

{block content}
    {if $log->getId()}
    <h2>Obsah záznamu s id {$log->getId()}</h2>
    {else}
    <h2>Neexistujúci záznam</h2>
    {/if}
    <a href="{createUri controller='admin_editor' action='index' params=['logs']}" style="float: right; margin-top: -2.8em;">&lt;&lt; Návrat na všetky záznamy</a>
    <div style="display: none; clear: both;"></div>
    {if $log->getId()}
    <fieldset class="logs">
        <legend>Obsah záznamu</legend>
        {if $log->getAdminEmail()}
        <div class="row">
            <div class="label">Administrátor:</div>
            <div class="content">{$log->getAdminEmail()}</div>
        </div>
        {/if}
        {if $log->getIpaddress()}
        <div class="row">
            <div class="label">IP adresa:</div>
            <div class="content">{$log->getIpaddress()}</div>
        </div>
        {/if}
        <div class="row">
            <div class="label">Správa:</div>
            <div class="content">{$log->getMessage()}</div>
        </div>
        <div class="row">
            <div class="label">Čas:</div>
            <div class="content">{$log->getCrdate()|date_format:'%d.%m.%Y %H:%M:%S'|default:'Neznámy čas'}</div>
        </div>
        <fieldset>
            <legend>Dáta správy</legend>
            {foreach $log->getLogData() as $key => $data}
            <div class="row">
                <div class="label">{$key|escape:'html'}:</div>
                <div class="content">{if is_array($data) or is_object($data)}<pre>{$data|print_r:1|escape:'html'}</pre>{else}{$data|escape:'html'}{/if}</div>
            </div>
            {foreachelse}
            <p>Tento záznam neobsahuje žiadne dáta.</p>
            {/foreach}
        </fieldset>
    </fieldset>
    {else}
    {include file='partials/admin_editor.error_msg.tpl' message='Zvolený záznam neexistuje.' inline}
    {/if}
{/block}