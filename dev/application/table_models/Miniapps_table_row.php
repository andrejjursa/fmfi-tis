<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Miniapps_table_row extends Abstract_table_row {
    
    /**
     * @var Abstract_table_relation relation to files.
     */
    private $files = NULL;
    
    /**
     * Relations initialise.
     */
    protected function init() {
        $this->files = $this->load->table_relation('miniapps', 'miniapp_files');
    }

    /**
     * Relation reset.
     */
    protected function resetRelations() {
        $this->files->reset();
    }

    /**
     * Return all files related to this relation.
     * 
     * @return array<Abstract_table_row> related files.
     */
    public function getFiles() {
        return $this->files->get($this->getId());
    }
    
    /**
     * Get editor data.
     * 
     * @return array<mixed> editor data for this row.
     */
    public function getDataForEditor() {
        $data = $this->data();
        
        $data['miniapp_files'] = $this->files->allIds($this->getId());
        
        return $data;
    }


}

?>