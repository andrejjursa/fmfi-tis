<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
      <title> Otázky... </title>
    </head>
	
    <body>	
	
		{foreach $questions as $question nocache}
	
		<div id="question_id_{$question->getId()}"> <!-- DIV pre otazku a odpovede -->		
        <h3>{$question->getQuestion()}</h3>

			{foreach $question->getAnswersRandom() as $answer nocache}
				{$answer->getAnswer()}  <button onclick="checkAnswer({$question->getId()},{$answer->getId()})">Odpovedať...</button><br />
			{/foreach}
		</div>
	{foreachelse}
		<p>Nenaši sa žadne otázky k fyzikovi.</p>
	{/foreach}
	
    </body>
</html>