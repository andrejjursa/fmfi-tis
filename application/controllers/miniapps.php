<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Miniapps extends Abstract_frontend_controller {
    
    public function index($id = NULL) {
        $miniapp = $this->load->table_row('miniapps');
        $miniapp->load($id);
        $this->parser->assign('miniapp', $miniapp);
        $this->parser->parse('frontend/miniapps.index.tpl');
    }
       
}