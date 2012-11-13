<?php /*%%SmartyHeaderCode:2922450a26e19407b59-73318580%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59e2ae8364a3e439df0ad0c564185cfe358b4134' => 
    array (
      0 => 'application\\views\\javascript\\timeline.js',
      1 => 1352824857,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2922450a26e19407b59-73318580',
  'cache_lifetime' => 3600,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50a2781e9d69f8_17290476',
  'variables' => 
  array (
    'start_year' => 0,
    'end_year' => 0,
  ),
  'has_nocache_code' => true,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50a2781e9d69f8_17290476')) {function content_50a2781e9d69f8_17290476($_smarty_tpl) {?>$(document).ready(function(){
    
    /**
     * This function will renew lists of physicists and inventions after stop sliding in slider.
     */
    sliderOnStop = function(event, ui) {
        var selected_year = ui.value;
        
        $('#timeline').slider('disable');
        
        var urlPatern = '<?php echo smartyCreateUri(array('controller'=>"timeline",'action'=>"ajaxUpdateList",'params'=>array("-YEAR-")),$_smarty_tpl);?>
';
        $.ajax(urlPatern.replace('-YEAR-', selected_year), {
            cache: false,
            dataType: 'json',
            success: function(data) {
                $('#physicists_container').html(data.physicists);
                $('#inventions_container').html(data.inventions);
            },
            complete: function() {
                $('#timeline').slider('enable');
            }
        });
    }
    
    /**
     * Creates slider and all its handlers.
     */
    insertTimeline = function() {
        $('#timeline').slider({
            orientation: "vertical",
            range: false,
            min: <?php echo $_smarty_tpl->tpl_vars['start_year']->value;?>
,
            max: <?php echo $_smarty_tpl->tpl_vars['end_year']->value;?>
,
            stop: sliderOnStop
        });
    }
    
    insertTimeline();
    
});<?php }} ?>