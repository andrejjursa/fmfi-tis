{extends file="layouts/frontend.tpl"}

{block name="content"} 
<table>
    <tbody>
        <tr>
            <td style="vertical-align: top;"></td>
            <td style="vertical-align: top;">
                <h2>Fyzici</h2>
                <div id="physicists_container">
                {include file='partials/timeline.index.physicists.tpl' physicists=$physicists year=$min_year}
                </div>
                <h2>Objavy fyzikov</h2>
                <div id="inventions_container">
                {include file='partials/timeline.index.inventions.tpl' inventions=$inventions year=$min_year}
                </div>
            </td>
        </tr>
    </tbody>
</table>
{/block}