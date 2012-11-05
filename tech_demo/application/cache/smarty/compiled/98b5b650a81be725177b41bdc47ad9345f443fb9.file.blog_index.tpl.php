<?php /* Smarty version Smarty-3.1.11, created on 2012-11-05 14:22:24
         compiled from "application\views\blog_index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:124255097a4049ff100-22972623%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '98b5b650a81be725177b41bdc47ad9345f443fb9' => 
    array (
      0 => 'application\\views\\blog_index.tpl',
      1 => 1352121718,
      2 => 'file',
    ),
    'e71d97be6f09fca9a49c86dcb53b2912252dac68' => 
    array (
      0 => 'application\\views\\blog_layout.tpl',
      1 => 1352114938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '124255097a4049ff100-22972623',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5097a404a7e9d2_24134563',
  'variables' => 
  array (
    'domain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5097a404a7e9d2_24134563')) {function content_5097a404a7e9d2_24134563($_smarty_tpl) {?><!DOCTYPE html>
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
        <h3><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getTitle(), ENT_QUOTES, 'UTF-8', true);?>
</h3>
        <div>
            <?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getText(), ENT_QUOTES, 'UTF-8', true));?>

        </div>
        <div>
            <?php  $_smarty_tpl->tpl_vars['tag'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tag']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blog_entry']->value->getTags(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tag']->key => $_smarty_tpl->tpl_vars['tag']->value){
$_smarty_tpl->tpl_vars['tag']->_loop = true;
?>
                <span style="border-right: 1px solid black; padding-right: 3px;"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tag']->value->getName(), ENT_QUOTES, 'UTF-8', true);?>
</span>
            <?php }
if (!$_smarty_tpl->tpl_vars['tag']->_loop) {
?>
                <span>Nie su priradene ziadne tagy ...</span>
            <?php } ?>
        </div>
        <div>
            Pocet komentarov: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getCommentsCount(), ENT_QUOTES, 'UTF-8', true);?>

        </div>
        <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;">
            <a href="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
index.php/blog/entry/id/<?php echo $_smarty_tpl->tpl_vars['blog_entry']->value->getId();?>
">Zobraz viacej ...</a>
        </div>
    <?php } ?>
</div>
</html><?php }} ?>