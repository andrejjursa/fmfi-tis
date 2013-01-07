{extends file='layouts/backend.tpl'}

{block name="content"}
<div id="dashboard">
    <p class="welcome">Vitajte v administrácii!</p>
    <p>Ste prihlásený ako <strong>{$Admins_model->getAdminEmail()}</strong>.</p>
    <fieldset>
        <legend>Prehľad dát systému</legend>
        <p>Štatistika tabuliek:</p>
        <table class="statistics">
            <thead>
                <tr>
                    <th>Tabuľka</th><th>Počet záznamov</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="header">Fyzici</td>
                    <td>{$physicists_count}</td>
                </tr>
                <tr>
                    <td class="header">Objavy</td>
                    <td>{$inventions_count}</td>
                </tr>
                <tr>
                    <td class="header">Obdobia</td>
                    <td>{$periods_count}</td>
                </tr>
                <tr>
                    <td class="header">Miniaplikácie</td>
                    <td>{$miniapps_count}</td>
                </tr>
                <tr>
                    <td class="header">Obrázky</td>
                    <td>{$images_count}</td>
                </tr>
            </tbody>
        </table>
    </fieldset>
    <fieldset>
        <legend>Posledné záznamy udalostí</legend>
        <div id="last_logs"></div>
    </fieldset>
</div>
{/block}