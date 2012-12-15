{$records = 0}
{foreach $physicists as $physicist nocache} 
{if $physicist->getBelongsToPeriod($current_period)}{$records = $records + 1}
    <div>
        <p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId(), $year, $current_period] nocache}">
            <strong>{$physicist->getName()}</strong>
            ({$physicist->getBirth_year()} - {if $physicist->getDeath_year() gte 9999}...{else}{$physicist->getDeath_year()}{/if})
        </a></p>
        {$physicist->getShort_description()}
    </div>
{/if}
{/foreach}
{if $records eq 0}
    <p>Nenašli sa žiadny fyzici pre rok {$year}.</p>
{/if}