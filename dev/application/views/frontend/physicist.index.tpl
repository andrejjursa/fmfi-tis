{extends file="layouts/frontend.tpl"}

{block name="content"}
<h1>
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
</div>
{/block}
