<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Answers extends Abstract_frontend_controller {

    
    /*
     * Checks value of column 'correct' in database of question by its ID
     * 
     * @param int $answer
     * @retrun boolean (type: json)
     */
    public function ajaxCheckAnswer($answer_id = NULL) {
        $this->output->set_content_type('application/json');
        if ($answer_id === NULL) {
            $this->output->set_output(json_encode(false));
            return;
        }
        
        $odpoved = -1;
        $answer = $this->load->table_row("answers");
        if ($answer->load($answer_id)) {
            $odpoved = intval($answer->getCorrect());
        } else {
            $this->output->set_output(json_encode(false));
            return;
        }
        
        if ($odpoved === 1) {
            $this->output->set_output(json_encode(true));
        } else {
            $this->output->set_output(json_encode(false));
        }
        return;
    }	
    
}