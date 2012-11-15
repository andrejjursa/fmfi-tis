{foreach $questions as $question nocache}
    <div>
        {$question->getQuestion()}
        {foreach $question->getAnswersRandom() as $answer}
            
        {/foreach}
    </div>
{foreachelse}
    <p>Nenašli sa žiadne otázky k fyzikovi.</p>
{/foreach}