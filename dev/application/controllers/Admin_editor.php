<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Admin_editor extends Abstract_backend_controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->parser->disable_caching();
    }
    
    public function index($table = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
        } else {
            $this->parser->assign('grid_settings', $table_collection->getGridSettings());
        }
        
        $this->parser->parse('backend/admin_editor.index.tpl', array());
    }
}

?>