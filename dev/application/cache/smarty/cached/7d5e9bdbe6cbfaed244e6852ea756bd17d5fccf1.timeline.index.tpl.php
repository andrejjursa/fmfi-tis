<?php /*%%SmartyHeaderCode:416750a20c20b1e309-53745688%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d5e9bdbe6cbfaed244e6852ea756bd17d5fccf1' => 
    array (
      0 => 'application\\views\\frontend\\timeline.index.tpl',
      1 => 1352824434,
      2 => 'file',
    ),
    'ddc67b91e8ebcb0b468a0a19d1f48e5f3f8b178d' => 
    array (
      0 => 'application\\views\\layouts\\frontend.tpl',
      1 => 1352822449,
      2 => 'file',
    ),
    '2c3fb2e9c52a84cfa2b4bbce325e96965a6346e9' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.physicists.tpl',
      1 => 1352796710,
      2 => 'file',
    ),
    '367e781d2b31269f5aa2e772b5cafa6dcfde5413' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.inventions.tpl',
      1 => 1352796710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '416750a20c20b1e309-53745688',
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a2781e7f3135_35805886',
  'variables' => 
  array (
    'site_base_url' => 0,
    'additional_css_files' => 0,
    'css_file' => 1,
    'additional_js_files' => 0,
    'js_file' => 1,
  ),
  'has_nocache_code' => true,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a2781e7f3135_35805886')) {function content_50a2781e7f3135_35805886($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link type="text/css" media="screen,print" rel="stylesheet" href="http://dev.tis.sk/public/css/smoothness/jquery-ui.css">
    <?php  $_smarty_tpl->tpl_vars['css_file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['css_file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['additional_css_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['css_file']->key => $_smarty_tpl->tpl_vars['css_file']->value){
$_smarty_tpl->tpl_vars['css_file']->_loop = true;
?><link type="text/css" media="<?php echo $_smarty_tpl->tpl_vars['css_file']->value->media;?>
" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['css_file']->value->href;?>
"><?php } ?>
    <script type="text/javascript" src="http://dev.tis.sk/public/js/jquery.js"></script>
    <script type="text/javascript" src="http://dev.tis.sk/public/js/jquery-ui.js"></script>
    <?php  $_smarty_tpl->tpl_vars['js_file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['additional_js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_file']->key => $_smarty_tpl->tpl_vars['js_file']->value){
$_smarty_tpl->tpl_vars['js_file']->_loop = true;
?><script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_file']->value->src;?>
"></script><?php } ?>
</head>
<body>
 
<table>
    <tbody>
        <tr>
            <td style="vertical-align: top;"><div id="timeline"></div></td>
            <td style="vertical-align: top;">
                <h2>Fyzici</h2>
                <div id="physicists_container">
                <?php  $_smarty_tpl->tpl_vars['physicist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['physicist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['physicists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['physicist']->key => $_smarty_tpl->tpl_vars['physicist']->value){
$_smarty_tpl->tpl_vars['physicist']->_loop = true;
?> 
    <div>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['physicist']->value->getName();?>
</strong> (<?php echo $_smarty_tpl->tpl_vars['physicist']->value->getBirth_year();?>
 - <?php if ($_smarty_tpl->tpl_vars['physicist']->value->getDeath_year()>=99999){?>...<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['physicist']->value->getDeath_year();?>
<?php }?>)</p>
        <?php echo $_smarty_tpl->tpl_vars['physicist']->value->getShort_description();?>

    </div>
<?php }
if (!$_smarty_tpl->tpl_vars['physicist']->_loop) {
?>
    <p>Nenašli sa žiadny fyzici pre rok <?php echo $_smarty_tpl->tpl_vars['year']->value;?>
.</p>
<?php } ?>                </div>
                <h2>Objavy fyzikov</h2>
                <div id="inventions_container">
                <?php  $_smarty_tpl->tpl_vars['invention'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invention']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['inventions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['invention']->key => $_smarty_tpl->tpl_vars['invention']->value){
$_smarty_tpl->tpl_vars['invention']->_loop = true;
?>
    <div>
        <p><strong><?php echo $_smarty_tpl->tpl_vars['invention']->value->getName();?>
</strong> (<?php echo $_smarty_tpl->tpl_vars['invention']->value->getYear();?>
)</p>
    </div>
<?php }
if (!$_smarty_tpl->tpl_vars['invention']->_loop) {
?>
    <p>Nenašli sa žiadne objavy fyzikov žijúcich v roku <?php echo $_smarty_tpl->tpl_vars['year']->value;?>
.</p>
<?php } ?>                </div>
            </td>
        </tr>
    </tbody>
</table>
                

</body>
</html><?php }} ?>