<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Periods_table_row extends Abstract_table_row {
    
    /**
     * @var Abstract_table_relation relation to physicists.
     */ 
    protected $physicists = null;
    
    /**
     * @var Abstract_table_relation relation to inventions.
     */
    protected $inventions = null;
    
    /**
     * Initialisation of relations.
     */
    protected function init() {
        $this->physicists = $this->load->table_relation('periods', 'physicists');
        $this->inventions = $this->load->table_relation('periods', 'inventions');    
    }
    
    /**
     * Reset of relations
     */
    protected function resetRelations() {
        $this->physicists->reset();    
        $this->physicists->reset();
    }
    
    /**
     * Returns all related physicists.
     * 
     * @return array<Abstract_table_row> list of physicists.
     */
    public function getPhysicists() {
        return $this->physicists->setOrderBy('name')->get($this->getId());
    }
    
    /**
     * Returns all related inventions.
     * 
     * @return array<Abstract_table_row> list of inventions.
     */
    public function getInventions() {
        return $this->inventions->setOrderBy('name')->get($this->getId());
    }
    
    /**
     * Returns data for editor.
     * 
     * @return array<mixed> data from this row.
     */
    public function getDataForEditor() {
        $data = $this->data();
		
		
        if (isset($data['end_year']) && intval($data['end_year']) < 9999) {
            $data['_is_over'] = TRUE;
        } else if (isset($data['end_year']) && intval($data['end_year']) >= 9999) {
            $data['_is_over'] = FALSE;
            unset($data['end_year']);
        } 

 
        $data['physicists'] = implode(',', $this->physicists->setOrderBy()->allIds($this->getId()));
        $data['inventions'] = implode(',', $this->inventions->setOrderBy()->allIds($this->getId()));
        
        return $data;
    }
    
    /**
     * Set data for this row from editor.
     * 
     * @param array<mixed> data.
     * @return void
     */
    public function prepareEditorSave($formdata) {

        if (!isset($formdata['_is_over'])) { $formdata['end_year'] = '9999'; }	
		unset($formdata['_is_over']);
	
        $physicists = $formdata['physicists'];
        unset($formdata['physicists']);
        
        $inventions = $formdata['inventions'];
        unset($formdata['inventions']);
        
        $this->load->helper('application');
        
        $this->physicists->setTo($this->getId(), expandRelationListToArray($physicists));
        $this->inventions->setTo($this->getId(), expandRelationListToArray($inventions));
        
        $this->data($formdata);
    }
    
    /**
     * Delete image when deleting this record.
     */
    protected function onDelete() {
        if ($this->getImage()) {
            $this->load->helper('application');
            deleteImageAndThumbs($this->getImage());
        }
    }
}

?>