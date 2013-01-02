<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Inventions extends Abstract_frontend_controller {
	
	public function index($id = 0, $year = 0, $period = 0) {
            $invention = $this->load->table_row('inventions');
            $invention->load(intval($id));
            $this->parser->assign('invention', $invention);
            $this->parser->assign("year", $year);
			$this->parser->assign("current_period", $period);
            $this->parser->setCacheId('invention_detail_' . intval($id));
            $this->_addTemplateJs('inventions/index.js');
            $this->_assignTemplateAdditionals();
            
            $this->parser->parse('frontend/inventions.index.tpl');
            
	}
	
}