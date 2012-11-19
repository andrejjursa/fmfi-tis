{extends file="layouts/frontend.tpl"}

{block name="content"}
    {if is_null($invention->getId()) or $invention->getDisplayed() eq 0}
        Zadany objav neexistuje!
    {else}
        <h1>{$invention->getName()|escape:"html"}</h1>
        <div class="content">{$invention->getDescription()}</div>
        <p><strong>Fyzici podielajuci sa na tomto objave:</strong></p>
        {foreach $invention->getPhysicists() as $physicist}{if $physicist->getDisplayed() eq 1}
            <div>
                <p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId()]}">
                    <strong>{$physicist->getName()}</strong>
                </a></p>
            </div>
        {/if}{foreachelse}
            <p>Ziadny fyzici sa nenasli ...</p>
        {/foreach}
    {/if}
{/block}