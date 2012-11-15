<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Questions extends Abstract_frontend_controller {
	
	public function index($id = 0){
		
		$questions = $this->load->table_collection('questions');
		$q = $questions->filterForPhysicist(intval($id))->execute()->get();
		
		$this->parser->parse('frontend/questions.index.tpl', array('questions' => $q));
		
	}
	
}