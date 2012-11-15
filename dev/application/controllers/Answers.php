<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Answers extends Abstract_frontend_controller {

    public function ajaxCheckAnswer($answer_id = NULL) {
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(true));
        
        
        //test
    }	
	
}