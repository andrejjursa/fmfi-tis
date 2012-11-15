{foreach $questions as $question nocache}
    <div>
        {$question->getQuestion()}
		<br />
        {foreach $question->getAnswersRandom() as $answer nocache}
            {$answer->getAnswer()} <br />
        {/foreach}
    </div>
{foreachelse}
    <p>Nenašli sa žiadne otázky k fyzikovi.</p>
{/foreach}