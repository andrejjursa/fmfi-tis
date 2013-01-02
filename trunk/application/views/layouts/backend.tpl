<!DOCTYPE html>
<html>
<head>
    <title>{block name="title"}{/block}</title>
    <meta charset="utf-8" />
    <link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/smoothness/jquery-ui.css" />
	<link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/admin_style.css" />
    <link rel="stylesheet" type="text/css" href="{$site_base_url}public/css/fancybox/jquery.fancybox.css" media="screen" />
    {foreach $additional_css_files as $css_file nocache}<link type="text/css" media="{$css_file->media}" rel="stylesheet" href="{$css_file->href}" />{/foreach}
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery.js"></script>
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery.mousewheel.pack.js"></script>
    <script type="text/javascript" src="{$site_base_url nocache}public/js/jquery.fancybox.pack.js"></script>
    {foreach $additional_js_files as $js_file nocache}<script type="text/javascript" src="{$js_file->src}"></script>{/foreach}
</head>
{function name='adminmenu' menu=[] level=0}
{if is_array($menu) and count($menu)}
<ul{if $level eq 0} id="jMenu"{/if}>
    {foreach $menu as $item}
    <li><a href="{if is_array($item.link)}{createUri controller=$item.link.controller action=$item.link.action params=$item.link.params}{else}{$item.link}{/if}" class="{$item.class}{if $level eq 0} fNiv{$first = 0}{/if}">{$item.title}</a>{adminmenu menu=$item.sub level=$level+1}</li>
    {/foreach}
</ul>
{/if}
{/function}
<body>
<h1>A D M I N I S T R Á C I A</h1>
{adminmenu menu=$adminmenu}
{block name="content"}
{/block}
</body>
</html>