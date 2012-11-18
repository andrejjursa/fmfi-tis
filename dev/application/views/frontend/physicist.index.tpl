{extends file="layouts/frontend.tpl"}

{block name="content"}
<h1 id="physicist_name" physicist_id="{$phys->getId()}" linkToDoTest="{createUri controller='questions' action='index' params=['-ID-'] nocache}">
{$phys->getName()}
</h1>
<div>
  <p>
    Rok narodenia: {$phys->getBirth_year()}
  </p>
  <p>
    Rok smrti: {$phys->getDeath_Year()}
  </p>
  <p>
    {$phys->getDescription()}
  </p>
    <p><button id="doTest">Pokúsiť sa urobiť test ...</button></p>
</div>
{/block}
