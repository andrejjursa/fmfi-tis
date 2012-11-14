<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Inventions extends Abstract_frontend_controller {
	
	public function index($id = 0){
		$id = (int) $id;
		
		$this->parser->parse("frontend/inventions.index.tpl", array(
			"inventions" => $this->load->table_collection("inventions")->filterOnlyDisplayed()->execute()->get(),
			"id" => $id
		));
	}
	
}