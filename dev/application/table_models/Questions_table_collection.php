<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Questions_table_collection extends Abstract_table_collection {
    
    public function filterForPhysicist($physicist_id) {
        $this->query->where('physicist_id', intval($physicist_id));
        
        return $this;
    }
    
}

?>