{extends file="layouts/frontend.tpl"}

{block name="content"}
<h1 id="physicist_name" physicist_id="{$phys->getId()}" linkToDoTest="{createUri controller='questions' action='index' params=['-ID-'] nocache}">
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
    <p><button id="doTest">Pokúsiť sa urobiť test ...</button></p>
</div>
{/block}
