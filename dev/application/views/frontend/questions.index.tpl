{foreach $questions as $question nocache}
    <div>
        {$question->getQuestion()}
        {foreach $question->getAnswersRandom() as $answer}
            
        {/foreach}
    </div>
{foreachelse}
    <p>Nena�li sa �iadne ot�zky k fyzikovi.</p>
{/foreach}