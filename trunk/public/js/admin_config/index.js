jQuery(document).ready(function($) {
   
    $('.button').button();
    
    $('[title]').tooltip();
    
    $('#config_config_encryption_key_generator_id').click(function() {
        var answer = confirm('Naozaj chcete vygenerovať nový kryptovací kľúč?');
        if (answer) {
            $.ajax('/index.php/admin_config/generateEncryptionKey', {
                cache: false,
                dataType: 'json',
                success: function(data) {
                    $('#config_config_encryption_key_id').val(data);
                },
                error: function() {
                    alert('Chyba komunikácie so serverom.');
                }
            });
        }
    });
    
    $('#test_email_button_id').click(function() {
        var email = prompt('Zadajte e-mailovú adresu, na ktorú chcete poslať skúšobný e-mail:');
        if (email !== null) {
            $.ajax('/index.php/admin_config/testEmailSending', {
                cache: false,
                dataType: 'json',
                type: 'post',
                data: { email: email },
                success: function(data) {
                    if (data.type == undefined || data.message == undefined) {
                        alert('Neznáma odpoved od serveru.');
                    } else {
                        if (data.type == 'success') {
                            alert('Úspech: ' + data.message);
                        } else {
                            alert('Chyba: ' + data.message);
                        }
                    }
                },
                error: function() {
                    alert('Chyba komunikácie so serverom.'); 
                }
            });
        }
    });
    
});