{foreach $physicists as $physicist nocache} 
    <div>
        <p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId(), $year] nocache}">
            <strong>{$physicist->getName()}</strong>
            ({$physicist->getBirth_year()} - {if $physicist->getDeath_year() gte 9999}...{else}{$physicist->getDeath_year()}{/if})
        </a></p>
        {$physicist->getShort_description()}
    </div>
{foreachelse}
    <p>Nenašli sa žiadny fyzici pre rok {$year}.</p>
{/foreach}