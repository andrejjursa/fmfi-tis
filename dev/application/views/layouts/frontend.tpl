<!DOCTYPE html>
<html>
<head>
    <title>{block name="title"}{/block}</title>
    <meta charset="utf-8">
    <link type="text/css" media="screen,print" rel="stylesheet" href="{$site_base_url}public/css/smoothness/jquery-ui.css">
    {foreach $additional_css_files as $css_file nocache}<link type="text/css" media="{$css_file->media}" rel="stylesheet" href="{$css_file->href}">{/foreach}
    <script type="text/javascript" src="{$site_base_url}public/js/jquery.js"></script>
    <script type="text/javascript" src="{$site_base_url}public/js/jquery-ui.js"></script>
    {foreach $additional_js_files as $js_file nocache}<script type="text/javascript" src="{$js_file->src}"></script>{/foreach}
</head>
<body>
{block name="content"}
{/block}
</body>
</html>