{extends file="layouts/frontend.tpl"}

{block name="content"}
<div id="physicists">
	<h1>Fyzici</h1>
	<div id="physicists_container">
		{include file='partials/timeline.index.physicists.tpl' physicists=$physicists year=$year inline}
	</div>
</div>
<div id="timelineWrap">
	{$max_year}
	<div id="timeline" style="height: 400px;"></div>
	{$min_year}
</div>
<div id="inventions">
	<h1>Objavy fyzikov</h1>
	<div id="inventions_container">
		{include file='partials/timeline.index.inventions.tpl' inventions=$inventions year=$year inline}
	</div>
</div>
{/block}

{block name='top_middle'}
    <form action="{createUri controller='timeline' action='index' params=['-1', '-PERIOD-']}" method="get">
        <select name="period" size="1" id="period_selector">
            {foreach $periods as $period}<option value="{$period->getId()}"{if $current_period eq $period->getId()} selected="selected"{/if}>{$period->getName()|escape:'html'}</option>{/foreach}
        </select>
    </form>
{/block}