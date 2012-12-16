{extends file="layouts/frontend.tpl"}

{block name="content"}
{include file='partials/breadcrumbs.tpl' year=$year current_period=$current_period inline}
{if is_null($phys->getId()) or $phys->getDisplayed() eq 0}
    <p>Zadaný fyzik neexistuje.</p>
{else}
    {if !is_null($phys->getPhotoObject()) and !is_null($phys->getPhotoObject()->getFile())}
      <img src="{imageThumb image=$phys->getPhotoObject()->getFile() width=120 height=120}" />
    {/if}
    <h1 id="physicist_name">
    {$phys->getName()}
    </h1>
    
    <div>
      <p>
        Rok narodenia: {$phys->getBirth_year()}
      </p>
    {if $phys->getDeath_Year() lt 9999}
      <p>
        Rok smrti: {$phys->getDeath_Year()}       
      </p>
    {/if}
      <p>
        {$phys->getDescription()} 
      </p>
      <p><a id="doTestLink" href="{createUri controller='questions' action='index' params=[$phys->getId()]}">Pokúsiť sa urobiť test ...</a></p>
    </div>
      
    {if count($phys->getImages())}
    <div id="images">
        {foreach $phys->getImages() as $image}{if !is_null($image->getFile())}
        <a href="{imageThumb image=$image->getFile()}" rel="fancybox" title="{$image->getDescription()|escape:'html'}">
        <img src="{imageThumb image=$image->getFile() width=90 height=90}" title="{$image->getDescription()|escape:'html'}" alt="{$image->getDescription()|escape:'html'}" />
        </a>
        {/if}{/foreach}
    </div>
    {/if}
    
    {if count($inventions)}
    <h2>Vynálezy, na ktorých sa {$phys->getName()} podieľal</h2>
    <ol>
    {foreach $inventions as $invention}
    	<li><a href="{createUri controller='inventions' action='index' params=[$invention->getId(), $year, $current_period]}">{$invention->getName()}</a></li>
    {/foreach}
    </ol>
    {/if}
    <h2>Miniaplikácie</h2>
    {if $phys->getMiniapps()}
    <ol>
    {foreach $phys->getMiniapps() as $miniapp}
        <li><a href="{createUri controller='miniapps' action='index' params=[$miniapp->getId()]}" rel="fancybox_ajax">{$miniapp->getName()|escape:'html'}</a></li>
    {/foreach}
    </ol>
    {else}
    <p>Neboli pridané žiadne miniaplikácie k tomuto fyzikovi.</p>
    {/if}
{/if}
{/block}
