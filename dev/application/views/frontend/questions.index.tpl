{foreach $questions as $question nocache}
    <div>
        {$question->getQuestion()}
    </div>
{foreachelse}
    <p>Nena�li sa �iadne ot�zky k fyzikovi.</p>
{/foreach}