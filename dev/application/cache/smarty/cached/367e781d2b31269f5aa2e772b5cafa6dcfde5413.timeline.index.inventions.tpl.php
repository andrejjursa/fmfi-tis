<?php /*%%SmartyHeaderCode:449350a2755db50784-50037022%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '367e781d2b31269f5aa2e772b5cafa6dcfde5413' => 
    array (
      0 => 'application\\views\\partials\\timeline.index.inventions.tpl',
      1 => 1352796710,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '449350a2755db50784-50037022',
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a3a888b207d7_56108769',
  'has_nocache_code' => true,
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a3a888b207d7_56108769')) {function content_50a3a888b207d7_56108769($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['invention'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invention']->_loop = false;
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
<?php } ?><?php }} ?>