{foreach $questions as $question nocache}
    <div>
        {$question->getQuestion()}
		<br />
        {foreach $question->getAnswersRandom() as $answer nocache}
            {$answer->getAnswer()} <br />
        {/foreach}
    </div>
{foreachelse}
    <p>Nena�li sa �iadne ot�zky k fyzikovi.</p>
{/foreach}