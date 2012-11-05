<?php /* Smarty version Smarty-3.1.11, created on 2012-11-05 13:54:07
         compiled from "application\views\blog_entry.tpl" */ ?>
<?php /*%%SmartyHeaderCode:227505097ad056e8147-22901404%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90ea997554d135d40d47bb407d42948843a31d8b' => 
    array (
      0 => 'application\\views\\blog_entry.tpl',
      1 => 1352120042,
      2 => 'file',
    ),
    'e71d97be6f09fca9a49c86dcb53b2912252dac68' => 
    array (
      0 => 'application\\views\\blog_layout.tpl',
      1 => 1352114938,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '227505097ad056e8147-22901404',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5097ad056e8b70_67751334',
  'variables' => 
  array (
    'domain' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5097ad056e8b70_67751334')) {function content_5097ad056e8b70_67751334($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\xampp\\htdocs\\tis\\tech_demo\\application\\third_party\\Smarty\\plugins\\modifier.date_format.php';
?><!DOCTYPE html>
<html>
    <h1>Ukazkovy blog</h1>
    <div>
        <a href="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
index.php/blog/index">Uvod</a>
    </div>
    <div>
    <?php if (is_null($_smarty_tpl->tpl_vars['blog_entry']->value)||is_null($_smarty_tpl->tpl_vars['blog_entry']->value->getId())){?>
        <h2>Chyba!</h2>
        <div>
            Pozadovana sprava sa nenasla ...
        </div>
    <?php }else{ ?>
        <h2><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getTitle(), ENT_QUOTES, 'UTF-8', true);?>
</h2>
        <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;"><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getText(), ENT_QUOTES, 'UTF-8', true));?>
</div>
        <h3>Komentare</h3>
        <?php  $_smarty_tpl->tpl_vars['blog_comment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blog_comment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blog_entry']->value->getComments(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blog_comment']->key => $_smarty_tpl->tpl_vars['blog_comment']->value){
$_smarty_tpl->tpl_vars['blog_comment']->_loop = true;
?>
            <div>Autor: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blog_comment']->value->getAuthor(), ENT_QUOTES, 'UTF-8', true);?>
 | <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['blog_comment']->value->getCrdate(),"%A - %e. %B %Y %H:%M:%S");?>
</div>
            <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;"><?php echo nl2br(htmlspecialchars($_smarty_tpl->tpl_vars['blog_comment']->value->getText(), ENT_QUOTES, 'UTF-8', true));?>
</div>
        <?php } ?>
        <?php echo my_validation_errors(array(),$_smarty_tpl);?>

        <form action="<?php echo $_smarty_tpl->tpl_vars['domain']->value;?>
index.php/blog/add_comment" method="post">
            <label>Meno autora:</label><br />
            <input type="text" name="comment[author]" value="<?php echo htmlspecialchars($_POST['comment']['author'], ENT_QUOTES, 'UTF-8', true);?>
" /><br />
            <label>Text:</label><br />
            <textarea name="comment[text]"><?php echo htmlspecialchars($_POST['comment']['text'], ENT_QUOTES, 'UTF-8', true);?>
</textarea><br />
            <input type="submit" value="Pridat komentar" />
            <input type="hidden" name="comment[blog_entry_id]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['blog_entry']->value->getId(), ENT_QUOTES, 'UTF-8', true);?>
" />
        </form>
    <?php }?>

</div>
</html><?php }} ?>