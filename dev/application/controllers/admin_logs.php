<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
 
class Admin_logs extends Abstract_backend_controller {
    
    public function index($id = NULL) {
        $log = $this->load->table_row('logs');
        $log->load($id);
        $this->parser->assign('log', $log);
        $this->parser->parse('backend/admin_logs.index.tpl');
    }
    
}

?>