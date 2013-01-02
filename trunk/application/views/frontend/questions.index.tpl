<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
      <title> Otázky... </title>
      <link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/smoothness/jquery-ui.css" />
      <link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/questions.css" />
      <script type="text/javascript" src="{$site_base_url}public/js/jquery.js"></script>
      <script type="text/javascript" src="{$site_base_url}public/js/jquery-ui.js"></script>
      <script type="text/javascript" src="{createUri controller="dynamicLoad" action="loadJS" params=["testhandling"]}"></script>
    </head>
	
    <body>	
	{nocache}{function name="points" points=0}{$points} {if $points eq 1}bod{elseif $points ge 2 and $points le 4}body{else}bodov{/if}{/function}{/nocache}
        {foreach $questions as $key => $question nocache}
            <!-- DIV pre otazku a odpovede -->
            <div class="question" id="question_id_{$question->getId()}" question_id="{$question->getId()}" question_value="{$question->getValue()}">
                <div class="question-counter">{$key+1}.</div>
                <div  class="question-points">Otázka je za {points points=$question->getValue()}</div>
                <div class="question-header">{$question->getQuestion()}</div>
                {if $question->getImage()}
                    <div class="question-image">
                        <img src="{imageThumb image=$question->getImage() width=180 height=180}" />
                    </div>
                {/if}
                
                <div class="question-answers">
                    {foreach $question->getAnswersRandom() as $key => $answer nocache}
                            <div class="question-answers-answer">
                                <div class="question-answers-answer-counter">{$key+1})</div>
                                <div class="question-answers-answer-selector">
                                    <button onclick="checkAnswer({$question->getId()},{$answer->getId()})">Odpovedať...</button>
                                </div>
                                {if $answer->getImage()}
                                    <div class="question-answers-answer-image">
                                        <img src="{imageThumb image=$answer->getImage() width=180 height=180}" />
                                    </div>
                                {/if}
                                <div class="question-answers-answer-text">
                                    {$answer->getAnswer()}
                                </div>
                            </div>
                    {/foreach}
                </div>
                
            </div>
            <!--div class="question" id="question_id_{$question->getId()}" question_id="{$question->getId()}" question_value="{$question->getValue()}"> 		
            <h3>{$question->getQuestion()} ({points points=$question->getValue()})</h3>
                {foreach $question->getAnswersRandom() as $answer nocache}
                        {$answer->getAnswer()}  <button onclick="checkAnswer({$question->getId()},{$answer->getId()})">Odpovedať...</button><br />
                {/foreach}
            </div-->
	{foreachelse}
		<p>Nenaši sa žadne otázky k fyzikovi.</p>
	{/foreach}
			
			
        <div id="testprogress"><div id="testprogress-text"></div></div>
	
    </body>
</html>