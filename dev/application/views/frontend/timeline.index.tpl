{extends file="layouts/frontend.tpl"}

{block name="content"}
<div id="content">
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
</div>
                {*['a'=>'cosi', 'b'=>12, 5]|print_r:true*}
{/block}