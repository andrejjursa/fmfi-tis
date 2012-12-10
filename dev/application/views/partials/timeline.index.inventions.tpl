{$records = 0}
{foreach $inventions as $invention nocache}
{if $invention->getBelongsToPeriod($current_period)}{$records = $records + 1}
    <div>
        <p><a href="{createUri controller='inventions' action='index' params=[$invention->getId(), $year]}">
            <strong>{$invention->getName()}</strong> ({$invention->getYear()})
        </a></p>
        {$invention->getShort_description()}
        <p><a href="{createUri controller='inventions' action='index' params=[$invention->getId(), $year]}">Viac informácií</a></p>
    </div>
{/if}
{/foreach}
{if $records eq 0}
    <p>Nenašli sa žiadne objavy fyzikov žijúcich v roku {$year}.</p>
{/if}