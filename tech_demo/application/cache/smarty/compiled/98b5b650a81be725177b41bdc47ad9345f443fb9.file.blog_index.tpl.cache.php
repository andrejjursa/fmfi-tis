<?php /* Smarty version Smarty-3.1.11, created on 2012-11-05 12:31:47
         compiled from "application\views\blog_index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:306985097a2834d3165-60088363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '98b5b650a81be725177b41bdc47ad9345f443fb9' => 
    array (
      0 => 'application\\views\\blog_index.tpl',
      1 => 1352115080,
      2 => 'file',
    ),
    'e71d97be6f09fca9a49c86dcb53b2912252dac68' => 
    array (
      0 => 'application\\views\\blog_layout.tpl',
      1 => 1352114938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '306985097a2834d3165-60088363',
  'function' => 
  array (
  ),
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5097a283e9a6a3_51775053',
  'variables' => 
  array (
    'domain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5097a283e9a6a3_51775053')) {function content_5097a283e9a6a3_51775053($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <h1>Ukazkovy blog</h1>
    <div>
        <a href="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
index.php/blog/index">Uvod</a>
    </div>
    <div>
    <h2>Zoznam sprav</h2>
    <?php  $_smarty_tpl->tpl_vars['blog_entry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blog_entry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blog_entries']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blog_entry']->key => $_smarty_tpl->tpl_vars['blog_entry']->value){
$_smarty_tpl->tpl_vars['blog_entry']->_loop = true;
?>
        <h3><?php echo $_smarty_tpl->tpl_vars['blog_entry']->value->getTitle();?>
</h3>
        <div>
            <?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getText(), ENT_QUOTES, 'UTF-8', true));?>

        </div>
    <?php } ?>
</div>
</html><?php }} ?>