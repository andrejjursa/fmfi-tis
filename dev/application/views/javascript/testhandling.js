$(document).ready(function(){
    
    var allQuestionsValues = new Array();
    var sumOfAllQuestionsValues = 0;
    var currentTestScore = 0;
    
    checkAnswer = function(question_id, answer_id) {
        disableQuestionAnswers(question_id);
        
        url = '{createUri controller="answers" action="ajaxCheckAnswer" params=["-ID-"] nocache}';
        
        $.ajax(url.replace('-ID-', answer_id), {
            cache: false,
            dataType: 'json',
            success: function(valid) {
                if (valid) {
                    currentTestScore += getQuestionValue(question_id);
                    changeProgressBarValue();
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
    
    getQuestionValue = function(question_id) {
        for(var i in allQuestionsValues) {
            if (allQuestionsValues[i].id == question_id) {
                return allQuestionsValues[i].value;
            }
        }
        return 0;
    }
    
    collectQuestionsValues = function() {
        $('div.question').each(function() {
            var id = $(this).attr('question_id');
            var value = $(this).attr('question_value');
            
            $(this).removeAttr('question_id');
            $(this).removeAttr('question_value');
            
            var data = new Object();
            data.id = id;
            data.value = parseInt(value);
            
            allQuestionsValues.push(data);
            sumOfAllQuestionsValues += parseInt(value);
        });
    }
    
    createProgressBar = function() {
        $('#testprogress').progressbar({
            value: 0,
            max: sumOfAllQuestionsValues
        });
    }
    
    changeProgressBarValue = function() {
        $('#testprogress').progressbar({
            value: currentTestScore
        });
        $("#testprogress-text").html(currentTestScore + " / " + sumOfAllQuestionsValues);
    }
    
    collectQuestionsValues();
    createProgressBar();
    
});