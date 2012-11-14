<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Inventions_table_collection extends Abstract_table_collection {

	/**
	 * @return Inventions_table_collection 
	 */
	public function filterOnlyDisplayed(){
		$this->query->where("displayed", 1);
        return $this;
	}
	
	public function filterByPhysicistId($id){
		
	}
}