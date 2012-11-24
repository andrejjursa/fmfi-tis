jQuery(document).ready(function($){
    
    $('#editor_tabs').tabs();
    
    $('div.highlight_field').mouseover(function(){
        $(this).css('background-color', '#F7F6CD'); 
    }).mouseout(function(){
        $(this).css('background-color', '');
    });
    
    $('label[title]').tooltip();
    
    $('a.button, input[type=submit].button, input[type=reset].button, input[type=button].button, button.button').button();
    
    $('form.editor').validate();
    
});