jQuery(document).ready(function($){
    var menuExists = false;
    $('#jMenu').each(function(){
        menuExists = true;
    });
    if (menuExists) {
        $('#jMenu').jMenu({
            openClick : false,
            ulWidth : 'auto',
            effects : {
                effectSpeedOpen : 150,
                effectSpeedClose : 150,
                effectTypeOpen : 'slide',
                effectTypeClose : 'hide',
                effectOpen : 'linear',
                effectClose : 'linear'
            },
            TimeBeforeOpening : 100,
            TimeBeforeClosing : 11,
            animatedText : false,
            paddingLeft: 1
        });
    }
    
    $('#jMenu a.logout_menu_button').click(function(event) {
        var answer = confirm('Naozaj sa chcete odhlásiť?');
        if (!answer) {
            event.preventDefault();
        }
    });
});