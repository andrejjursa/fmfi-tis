<?php /* Smarty version Smarty-3.1.11, created on 2012-11-14 16:30:37
         compiled from "application\views\frontend\timeline.index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:416750a20c20b1e309-53745688%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d5e9bdbe6cbfaed244e6852ea756bd17d5fccf1' => 
    array (
      0 => 'application\\views\\frontend\\timeline.index.tpl',
      1 => 1352906290,
      2 => 'file',
    ),
    'ddc67b91e8ebcb0b468a0a19d1f48e5f3f8b178d' => 
    array (
      0 => 'application\\views\\layouts\\frontend.tpl',
      1 => 1352825990,
      2 => 'file',
    ),
    '2c3fb2e9c52a84cfa2b4bbce325e96965a6346e9' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.physicists.tpl',
      1 => 1352754316,
      2 => 'file',
    ),
    '367e781d2b31269f5aa2e772b5cafa6dcfde5413' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.inventions.tpl',
      1 => 1352907034,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '416750a20c20b1e309-53745688',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a20c210694c8_36849688',
  'variables' => 
  array (
    'site_base_url' => 0,
    'additional_css_files' => 0,
    'css_file' => 1,
    'additional_js_files' => 0,
    'js_file' => 1,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a20c210694c8_36849688')) {function content_50a20c210694c8_36849688($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link type="text/css" media="screen,print" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['site_base_url']->value;?>
public/css/smoothness/jquery-ui.css">
    <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php  $_smarty_tpl->tpl_vars[\'css_file\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'css_file\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'additional_css_files\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'css_file\']->key => $_smarty_tpl->tpl_vars[\'css_file\']->value){
$_smarty_tpl->tpl_vars[\'css_file\']->_loop = true;
?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
<link type="text/css" media="<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'css_file\']->value->media;?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
" rel="stylesheet" href="<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'css_file\']->value->href;?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
"><?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php } ?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['site_base_url']->value;?>
public/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['site_base_url']->value;?>
public/js/jquery-ui.js"></script>
    <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php  $_smarty_tpl->tpl_vars[\'js_file\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'js_file\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'additional_js_files\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'js_file\']->key => $_smarty_tpl->tpl_vars[\'js_file\']->value){
$_smarty_tpl->tpl_vars[\'js_file\']->_loop = true;
?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'js_file\']->value->src;?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
"></script><?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php } ?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

</head>
<body>
 
<table>
    <tbody>
        <tr>
            <td style="vertical-align: top;"><?php echo $_smarty_tpl->tpl_vars['max_year']->value;?>
<div id="timeline" style="height: 200px;"></div><?php echo $_smarty_tpl->tpl_vars['year']->value;?>
</td>
            <td style="vertical-align: top;">
                <h2>Fyzici</h2>
                <div id="physicists_container">
                <?php /*  Call merged included template "partials/timeline.index.physicists.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('partials/timeline.index.physicists.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('physicists'=>$_smarty_tpl->tpl_vars['physicists']->value,'year'=>$_smarty_tpl->tpl_vars['year']->value), 0, '416750a20c20b1e309-53745688');
content_50a3b91d4a6a29_70875331($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "partials/timeline.index.physicists.tpl" */?>
                </div>
                <h2>Objavy fyzikov</h2>
                <div id="inventions_container">
                <?php /*  Call merged included template "partials/timeline.index.inventions.tpl" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate('partials/timeline.index.inventions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array('inventions'=>$_smarty_tpl->tpl_vars['inventions']->value,'year'=>$_smarty_tpl->tpl_vars['year']->value), 0, '416750a20c20b1e309-53745688');
content_50a3b91d4da2a9_26102214($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "partials/timeline.index.inventions.tpl" */?>
                </div>
            </td>
        </tr>
    </tbody>
</table>
                

</body>
</html><?php }} ?><?php /* Smarty version Smarty-3.1.11, created on 2012-11-14 16:30:37
         compiled from "application\views\partials\timeline.index.physicists.tpl" */ ?>
<?php if ($_valid && !is_callable('content_50a3b91d4a6a29_70875331')) {function content_50a3b91d4a6a29_70875331($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php  $_smarty_tpl->tpl_vars[\'physicist\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'physicist\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'physicists\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'physicist\']->key => $_smarty_tpl->tpl_vars[\'physicist\']->value){
$_smarty_tpl->tpl_vars[\'physicist\']->_loop = true;
?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
 
    <div>
        <p><strong><?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'physicist\']->value->getName();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
</strong> (<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'physicist\']->value->getBirth_year();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
 - <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php if ($_smarty_tpl->tpl_vars[\'physicist\']->value->getDeath_year()>=99999){?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
...<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php }else{ ?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'physicist\']->value->getDeath_year();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php }?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
)</p>
        <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'physicist\']->value->getShort_description();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

    </div>
<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php }
if (!$_smarty_tpl->tpl_vars[\'physicist\']->_loop) {
?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

    <p>Nenašli sa žiadny fyzici pre rok <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'year\']->value;?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
.</p>
<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php } ?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
<?php }} ?><?php /* Smarty version Smarty-3.1.11, created on 2012-11-14 16:30:37
         compiled from "application\views\partials\timeline.index.inventions.tpl" */ ?>
<?php if ($_valid && !is_callable('content_50a3b91d4da2a9_26102214')) {function content_50a3b91d4da2a9_26102214($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php  $_smarty_tpl->tpl_vars[\'invention\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'invention\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'inventions\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'invention\']->key => $_smarty_tpl->tpl_vars[\'invention\']->value){
$_smarty_tpl->tpl_vars[\'invention\']->_loop = true;
?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

    <div>
        <p><strong><?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'invention\']->value->getName();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
</strong> (<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'invention\']->value->getYear();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
)</p>
        <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'invention\']->value->getShort_description();?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

        <p><a href="<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo smartyCreateUri(array(\'controller\'=>\'inventions\',\'action\'=>\'index\',\'params\'=>array($_smarty_tpl->tpl_vars[\'invention\']->value->getId())),$_smarty_tpl);?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
">Viac informácií</a></p>
    </div>
<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php }
if (!$_smarty_tpl->tpl_vars[\'invention\']->_loop) {
?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>

    <p>Nenašli sa žiadne objavy fyzikov žijúcich v roku <?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php echo $_smarty_tpl->tpl_vars[\'year\']->value;?>
/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
.</p>
<?php echo '/*%%SmartyNocache:416750a20c20b1e309-53745688%%*/<?php } ?>/*/%%SmartyNocache:416750a20c20b1e309-53745688%%*/';?>
<?php }} ?>