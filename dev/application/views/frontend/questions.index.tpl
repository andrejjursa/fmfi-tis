{foreach $questions as $question nocache}
    <div>
        {$question->getQuestion()}
    </div>
{foreachelse}
    <p>Nenašli sa žiadne otázky k fyzikovi.</p>
{/foreach}