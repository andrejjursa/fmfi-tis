{extends file="layouts/frontend.tpl"}

{block name="content"}
<div id="breadcrumbs">
	<a href="{createUri controller="timeline" action="index" params=[$year]}">Úvod</a>
</div>
    {if is_null($invention->getId()) or $invention->getDisplayed() eq 0}
        Zadaný objav neexistuje!
    {else}
        <h1>{$invention->getName()|escape:"html"}</h1>
        <div class="content">{$invention->getDescription()}</div>
        <p><strong>Fyzici podieľajúci sa na tomto objave:</strong></p>
        {foreach $invention->getPhysicists() as $physicist}{if $physicist->getDisplayed() eq 1}
            <div>
                <p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId(), $year]}">
                    <strong>{$physicist->getName()}</strong>
                </a></p>
            </div>
        {/if}{foreachelse}
            <p>Žiadny fyzici sa nenašli...</p>
        {/foreach}
    {/if}
{/block}