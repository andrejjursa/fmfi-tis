{extends file="layouts/frontend.tpl"}

{block name="content"}
{include file='partials/breadcrumbs.tpl' year=$year current_period=$current_period inline}
    {if is_null($invention->getId()) or $invention->getDisplayed() eq 0}
        Zadaný objav neexistuje!
    {else}
        <h1>{$invention->getName()|escape:"html"}</h1>
        <div class="content">{$invention->getDescription()}</div>
        <p><strong>Fyzici podieľajúci sa na tomto objave:</strong></p>
        {foreach $invention->getPhysicists(TRUE) as $physicist}
            <div>
                <p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId(), $year, $current_period]}">
                    <strong>{$physicist->getName()}</strong>
                </a></p>
            </div>
        {foreachelse}
            <p>Žiadny fyzici sa nenašli...</p>
        {/foreach}
        <h2>Miniaplikácie</h2>
        {if $invention->getMiniapps()}
        <ol>
        {foreach $invention->getMiniapps() as $miniapp}
            <li><a href="{createUri controller='miniapps' action='index' params=[$miniapp->getId()]}" rel="fancybox_ajax">{$miniapp->getName()|escape:'html'}</a></li>
        {/foreach}
        </ol>
        {else}
        <p>Neboli pridané žiadne miniaplikácie k tomuto objavu.</p>
        {/if}
    {/if}
{/block}