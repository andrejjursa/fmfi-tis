{foreach $questions as $question nocache}
    <div>
        <h2>{$question->getQuestion()}</h2>
		<br />
        {foreach $question->getAnswersRandom() as $answer nocache}
            {$answer->getAnswer()} <br />
        {/foreach}
    <br />
	</div>
{foreachelse}
    <p>Nenašli sa žiadne otázky k fyzikovi.</p>
{/foreach}