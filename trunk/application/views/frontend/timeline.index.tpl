{extends file="layouts/frontend.tpl"}

{block name="content"}
{if !$no_period}
    <div id="timelineInnerWrap">
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
        <div id="dataForJS">
            <input type="hidden" name="background" value="{$dataForJS.background|escape:'html'}" />
            <input type="hidden" name="number_color" value="{$dataForJS.number_color|escape:'html'}" />
            <input type="hidden" name="border_color" value="{$dataForJS.border_color|escape:'html'}" />
        </div>
        <div class="clear"></div>
    </div>
    <div id="periodInfo">
        <h1>{$period->getName()|escape:'html'}</h1>
        <div id="periodTabs">
            <ul>
                <li><a href="#periodtab-1">O období</a></li>
                <li><a href="#periodtab-2">Fyzici obdobia</a></li>
                <li><a href="#periodtab-3">Objavy obdobia</a></li>
            </ul>
            <div id="periodtab-1">{$period->getDescription()}</div>
            <div id="periodtab-2">
                {foreach $period->getPhysicists(TRUE) as $physicist}
                <div>
                    <p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId(), $year, $current_period]}">{$physicist->getName()|escape:'html'}</a> ({$physicist->getBirth_year()} - {if $physicist->getDeath_year() ge 9999}...{else}{$physicist->getDeath_year()}{/if})</p>
                    {$physicist->getShort_description()}
                </div>
                {foreachelse}
                <div>
                    <p>Toto obdobie nemá žiadnych fyzikov.</p>
                </div>
                {/foreach}
            </div>
            <div id="periodtab-3">
                {foreach $period->getInventions(TRUE) as $invention}
                <div>
                    <p><a href="{createUri controller='physicist' action='index' params=[$invention->getId(), $year, $current_period]}">{$invention->getName()|escape:'html'}</a> ({$invention->getYear()})</p>
                    {$invention->getShort_description()}
                </div>
                {foreachelse}
                <div>
                    <p>Toto obdobie nemá žiadne objavy.</p>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
{else}
    <div id="no_period">
        <p><strong>Vitajte na stránke!</strong></p>
        <p>Bohužiaľ, v tejto chvíli nie je prístupný žiaden obsah, skúste sa na stránku vrátit neskôr.</p>
    </div>
{/if}
{/block}

{block name='top_middle'}
    {if !$no_period}
    <form action="{createUri controller='timeline' action='index' params=['_', '-PERIOD-']}" method="get">
			<select name="period" size="1" id="period_selector">
				{foreach $periods as $_period}<option value="{$_period->getId()}"{if $current_period eq $_period->getId()} selected="selected"{/if}>{$_period->getName()|escape:'html'}</option>{/foreach}
			</select>
    </form>
    {/if}
{/block}