$(document).ready(function(){
    
    checkAnswer = function(question_id, answer_id) {
        disableQuestionAnswers(question_id);
        
        url = '{createUri controller="answers" action="ajaxCheckAnswer" params=["-ID-"] nocache}';
        
        $.ajax(url.replace('-ID-', answer_id), {
            cache: false,
            dataType: 'json',
            success: function(valid) {
                if (valid) {
                    alert('SPEAVNA ODPOVED!');
                } else {
                    alert('NESPRAVNA ODPOVED, SI HLUPAK!!!');
                }
            },
            error: function() {
                enableQuestionAnswers(question_id);
            }
        });
    }
    
    disableQuestionAnswers = function(question_id) {
        $('#question_id_' + question_id + ' button').attr('disabled', 'disabled');
    }
    
    enableQuestionAnswers = function(question_id) {
        $('#question_id_' + question_id + ' button').removeAttr('disabled');
    }
    
});