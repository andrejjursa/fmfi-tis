<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Inventions extends Abstract_frontend_controller {
	
	public function index($id = 0, $returnYear = 0) {
            if (!$this->parser->isCached('frontend/inventions.index.tpl', 'invention_detail_' . intval($id))) {
                $invention = $this->load->table_row('inventions');
                $invention->load(intval($id));
                $this->parser->assign('invention', $invention);
            }
            $this->parser->assign("year", $returnYear);
            $this->parser->setCacheId('invention_detail_' . intval($id));
            $this->parser->parse('frontend/inventions.index.tpl');
	}
	
}