{extends file="layouts/frontend.tpl"}

{block name="content"} 
<table>
    <tbody>
        <tr>
            <td style="vertical-align: top;">{$max_year}<div id="timeline" style="height: 200px;"></div>{$year}</td>
            <td style="vertical-align: top;">
                <h2>Fyzici</h2>
                <div id="physicists_container">
                {include file='partials/timeline.index.physicists.tpl' physicists=$physicists year=$year inline}
                </div>
                <h2>Objavy fyzikov</h2>
                <div id="inventions_container">
                {include file='partials/timeline.index.inventions.tpl' inventions=$inventions year=$year inline}
                </div>
            </td>
        </tr>
    </tbody>
</table>
                {*['a'=>'cosi', 'b'=>12, 5]|print_r:true*}
{/block}