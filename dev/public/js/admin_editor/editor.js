jQuery(document).ready(function($){
    
    $('#editor_tabs').tabs();
    
    $('div.highlight_field').mouseover(function(){
        $(this).css('background-color', '#F7F6CD'); 
    }).mouseout(function(){
        $(this).css('background-color', '');
    });
    
    $('label[title]').tooltip();
    
    $('a.button, input[type=submit].button, input[type=reset].button, input[type=button].button, button.button').button();
    
    
    $('form.editor').validate({
        ignore: '',
        errorPlacement: function(error, element) {
            var elem_error_container = element.parent('div.editor_field_line').find('div.error_container');
            error.appendTo(elem_error_container);
        }
    });
    
    $.extend($.validator.messages, {
        required: "Táto položka je vyžadovaná.",
        remote: "Prosím opravte toto pole.",
        email: "Prosím vložte správnu e-mailovú adresu.",
        url: "Prosím vložte správnu URL adresu.",
        date: "Prosím vložte správny dátum.",
        dateISO: "Prosím vložte správny dátum (ISO formát).",
        number: "Prosím vložte správne číslo.",
        digits: "Prosím vložte iba číslice.",
        creditcard: "Prosím vlošte správne číslo kreditnej karty.",
        equalTo: "Prosím vyplnte pole rovnako ako predchodzie.",
        accept: "Prosím vložte súbor so správnou príponou.",
        maxlength: jQuery.validator.format("Prosím vložte maximálne {0} znakov."),
        minlength: jQuery.validator.format("Prosím vložte aspoň {0} znakov."),
        rangelength: jQuery.validator.format("Prosím vložte {0} až {1} znakov."),
        range: jQuery.validator.format("Prosím vložte hodnotu medzi {0} až {1}."),
        max: jQuery.validator.format("Prosím vložte hodnotu menšiu alebo rovnú {0}."),
        min: jQuery.validator.format("Prosím vložte hodnotu väčšiu alebo rovnú {0}.")
    });
    
    $('textarea.tinymce').tinymce({
        script_url: $('#site_base_url').attr('rel') + 'public/js/tinymce/tiny_mce.js',
        
        theme: 'advanced',
        plugins: 'pagebreak,style,layer,table,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
        
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,advhr,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking",
        theme_advanced_toolbar_location : 'top',
        theme_advanced_toolbar_align : 'left',
        theme_advanced_statusbar_location : 'bottom',
        theme_advanced_resizing: false,
        
        onchange_callback: function(editor) {
            $('#' + editor.id).valid();
        }
    });
    
});