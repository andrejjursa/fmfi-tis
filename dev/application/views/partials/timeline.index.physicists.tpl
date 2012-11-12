{foreach $physicists as $physicist nocache} 
    <div>
        <p><strong>{$physicist->getName()}</strong> ({$physicist->getBirth_year()} - {if $physicist->getDeath_year() gte 99999}...{else}{$physicist->getDeath_year()}{/if})</p>
        {$physicist->getShort_description()}
    </div>
{foreachelse}
    <p>Nenašli sa žiadny fyzici pre rok {$year}.</p>
{/foreach}