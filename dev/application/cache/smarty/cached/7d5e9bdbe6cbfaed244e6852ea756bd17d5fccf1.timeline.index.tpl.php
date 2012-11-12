<?php /*%%SmartyHeaderCode:1675550a13d9a0101a1-89951412%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d5e9bdbe6cbfaed244e6852ea756bd17d5fccf1' => 
    array (
      0 => 'application\\views\\frontend\\timeline.index.tpl',
      1 => 1352750999,
      2 => 'file',
    ),
    'ddc67b91e8ebcb0b468a0a19d1f48e5f3f8b178d' => 
    array (
      0 => 'application\\views\\layouts\\frontend.tpl',
      1 => 1352744248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1675550a13d9a0101a1-89951412',
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a15798e25e95_53137588',
  'has_nocache_code' => true,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a15798e25e95_53137588')) {function content_50a15798e25e95_53137588($_smarty_tpl) {?><html>
<head>
    <title></title>
</head>
<body>
 
<table>
    <tbody>
        <tr>
            <td style="vertical-align: top;"></td>
            <td style="vertical-align: top;">
                <h2>Fyzici</h2>
                <div id="physicists_container">
                <?php  $_smarty_tpl->tpl_vars['physicist'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['physicist']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['default_physicists']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                    <p>Nenašli sa žiadny fyzici pre rok <?php echo $_smarty_tpl->tpl_vars['min_year']->value;?>
.</p>
                <?php } ?>
                </div>
                <h2>Objavy fyzikov</h2>
                <div id="inventions_container">
                <?php  $_smarty_tpl->tpl_vars['invention'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['invention']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['default_inventions']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                    <p>Nenašli sa žiadny fyzici pre rok <?php echo $_smarty_tpl->tpl_vars['min_year']->value;?>
.</p>
                <?php } ?>
                </div>
            </td>
        </tr>
    </tbody>
</table>

</body>
</html><?php }} ?>