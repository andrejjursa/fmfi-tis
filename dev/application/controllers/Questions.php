<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Questions extends Abstract_frontend_controller {
	
	public function index($id = 0){
		$id = (int) $id;
		
		$questions = $this->load->table_collection('questions');
		$questions->filterForPhysicist($id)->execute();
		$questions->parser->parse('frontend/questions.index.tpl');
		
	}
	
}