{foreach $inventions as $invention nocache}
    <div>
        <p><strong>{$invention->getName()}</strong> ({$invention->getYear()})</p>
    </div>
{foreachelse}
    <p>Nenašli sa žiadne objavy fyzikov žijúcich v roku {$year}.</p>
{/foreach}