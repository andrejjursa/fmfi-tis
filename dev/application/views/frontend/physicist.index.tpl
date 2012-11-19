{extends file="layouts/frontend.tpl"}

{block name="content"}
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
{/block}
