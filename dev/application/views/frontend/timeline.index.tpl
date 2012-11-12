{extends file="layouts/frontend.tpl"}

{block name="content"} 
<table>
    <tbody>
        <tr>
            <td style="vertical-align: top;"></td>
            <td style="vertical-align: top;">
                <h2>Fyzici</h2>
                <div id="physicists_container">
                {foreach $default_physicists as $physicist nocache} 
                    <div>
                        <p><strong>{$physicist->getName()}</strong> ({$physicist->getBirth_year()} - {if $physicist->getDeath_year() gte 99999}...{else}{$physicist->getDeath_year()}{/if})</p>
                        {$physicist->getShort_description()}
                    </div>
                {foreachelse}
                    <p>Nenašli sa žiadny fyzici pre rok {$min_year}.</p>
                {/foreach}
                </div>
                <h2>Objavy fyzikov</h2>
                <div id="inventions_container">
                {foreach $default_inventions as $invention nocache}
                    <div>
                        <p><strong>{$invention->getName()}</strong> ({$invention->getYear()})</p>
                    </div>
                {foreachelse}
                    <p>Nenašli sa žiadny fyzici pre rok {$min_year}.</p>
                {/foreach}
                </div>
            </td>
        </tr>
    </tbody>
</table>
{/block}