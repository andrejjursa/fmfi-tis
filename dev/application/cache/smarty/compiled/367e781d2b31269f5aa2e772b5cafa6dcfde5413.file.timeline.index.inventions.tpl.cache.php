<?php /* Smarty version Smarty-3.1.11, created on 2012-11-14 16:30:47
         compiled from "application\views\partials\timeline.index.inventions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:449350a2755db50784-50037022%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '367e781d2b31269f5aa2e772b5cafa6dcfde5413' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.inventions.tpl',
      1 => 1352907034,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '449350a2755db50784-50037022',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a2755db6a102_66733010',
  'variables' => 
  array (
    'inventions' => 0,
    'invention' => 1,
    'year' => 1,
  ),
  'has_nocache_code' => true,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a2755db6a102_66733010')) {function content_50a2755db6a102_66733010($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php  $_smarty_tpl->tpl_vars[\'invention\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'invention\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'inventions\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'invention\']->key => $_smarty_tpl->tpl_vars[\'invention\']->value){
$_smarty_tpl->tpl_vars[\'invention\']->_loop = true;
?>/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>

    <div>
        <p><strong><?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php echo $_smarty_tpl->tpl_vars[\'invention\']->value->getName();?>
/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>
</strong> (<?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php echo $_smarty_tpl->tpl_vars[\'invention\']->value->getYear();?>
/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>
)</p>
        <?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php echo $_smarty_tpl->tpl_vars[\'invention\']->value->getShort_description();?>
/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>

        <p><a href="<?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php echo smartyCreateUri(array(\'controller\'=>\'inventions\',\'action\'=>\'index\',\'params\'=>array($_smarty_tpl->tpl_vars[\'invention\']->value->getId())),$_smarty_tpl);?>
/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>
">Viac informácií</a></p>
    </div>
<?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php }
if (!$_smarty_tpl->tpl_vars[\'invention\']->_loop) {
?>/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>

    <p>Nenašli sa žiadne objavy fyzikov žijúcich v roku <?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php echo $_smarty_tpl->tpl_vars[\'year\']->value;?>
/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>
.</p>
<?php echo '/*%%SmartyNocache:449350a2755db50784-50037022%%*/<?php } ?>/*/%%SmartyNocache:449350a2755db50784-50037022%%*/';?>
<?php }} ?>