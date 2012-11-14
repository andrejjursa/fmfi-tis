<?php /*%%SmartyHeaderCode:54850a2755da62408-83738607%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c3fb2e9c52a84cfa2b4bbce325e96965a6346e9' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.physicists.tpl',
      1 => 1352796710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54850a2755da62408-83738607',
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a3b8886f54c4_03853087',
  'has_nocache_code' => true,
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a3b8886f54c4_03853087')) {function content_50a3b8886f54c4_03853087($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['physicist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['physicist']->_loop = false;
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
<?php } ?><?php }} ?>