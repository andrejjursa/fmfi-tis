{foreach $inventions as $invention nocache}
    <div>
        <p><a href="{createUri controller='inventions' action='index' params=[$invention->getId(), $year]}">
            <strong>{$invention->getName()}</strong> ({$invention->getYear()})
        </a></p>
        {$invention->getShort_description()}
        <p><a href="{createUri controller='inventions' action='index' params=[$invention->getId()]}">Viac informácií</a></p>
    </div>
{foreachelse}
    <p>Nenašli sa žiadne objavy fyzikov žijúcich v roku {$year}.</p>
{/foreach}