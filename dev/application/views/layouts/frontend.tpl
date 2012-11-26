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
		</div>
{block name="content"}
{/block}

		<div id="footer">
			&copy; Fyzika {date("Y")}
		</div>

	</div>
	
</body>
</html>