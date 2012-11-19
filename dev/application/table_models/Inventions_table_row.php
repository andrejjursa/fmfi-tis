<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Inventions_table_row extends Abstract_table_row {
    protected $physicists = null;
    
    protected function init() {
        $this->physicists = $this->load->table_relation('inventions', 'physicists');
    }
    
    protected function resetRelations() {
        $this->physicists->reset();
    }
    
    public function getPhysicists() {
        return $this->physicists->get($this->getId());
    }
}

?>