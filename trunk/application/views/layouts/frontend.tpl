<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk">
<head>
    <title>{block name="title"}{/block}</title>
    <meta charset="utf-8" />
    <link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/smoothness/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="{$site_base_url}public/css/screen.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="{$site_base_url}public/css/fancybox/jquery.fancybox.css" media="screen" />
    {foreach $additional_css_files as $css_file nocache}<link type="text/css" media="{$css_file->media}" rel="stylesheet" href="{$css_file->href}" />{/foreach}
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery.js"></script>
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery.mousewheel.pack.js"></script>
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery.fancybox.pack.js"></script>
    {foreach $additional_js_files as $js_file nocache}<script type="text/javascript" src="{$js_file->src}"></script>{/foreach}
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<a href="/"><img src="{$site_base_url}public/images/einstein.png" alt="Albert Einstein" /></a>
            <div id="navbar">
                {block name='top_middle'}{/block}
            </div>
			{if get_class($this) neq "Timeline"}
			<div id="breadcrumbs">
				<a href="{createUri controller="timeline" action="index" params=[$year, $current_period]}">&laquo; Späť na časovú os</a>
			</div>
			{/if}
		</div>
		<div id="content">
{block name="content"}
{/block}
		</div>
		<div style="clear: both;"></div>
	</div>
	<div id="footer">
		&copy; 2012 - 2013 FMFI UK, FuTeX team z predmetu Tvorba informačných systémov
	</div>
</body>
</html>