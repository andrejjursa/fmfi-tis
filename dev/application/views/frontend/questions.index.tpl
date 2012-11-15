<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
      <title> Otázky... </title>
      <link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/smoothness/jquery-ui.css">
      <script type="text/javascript" src="{$site_base_url}public/js/jquery.js"></script>
      <script type="text/javascript" src="{$site_base_url}public/js/jquery-ui.js"></script>
      <script type="text/javascript" src="{createUri controller="dynamicLoad" action="loadJS" params=["testhandling"]}"></script>
    </head>
	
    <body>	
	{function name="pocetBodov"}{$body} {if $body eq 1}bod{elseif $body ge 2 and $body le 4}body{else}bodov{/if}{/function}
		{foreach $questions as $question nocache}
	
		<div class="question" id="question_id_{$question->getId()}" question_id="{$question->getId()}" question_value="{$question->getValue()}"> <!-- DIV pre otazku a odpovede -->		
        <h3>{$question->getQuestion()} ({pocetBodov body=$question->getValue()})</h3>

			{foreach $question->getAnswersRandom() as $answer nocache}
				{$answer->getAnswer()}  <button onclick="checkAnswer({$question->getId()},{$answer->getId()})">Odpovedať...</button><br />
			{/foreach}
		</div>
	{foreachelse}
		<p>Nenaši sa žadne otázky k fyzikovi.</p>
	{/foreach}
			
			
		<br /><br /><br /><br />	
        <div id="testprogress" style="width: 200px;"></div>
	
    </body>
</html>