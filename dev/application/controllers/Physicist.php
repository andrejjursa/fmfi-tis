<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Physicist extends Abstract_frontend_controller {
    
    public function index($id = 1, $returnYear = 0){
  		if (!$this->parser->isCached('frontend/physicist.index.tpl', 'physicist_detail_for_' + intval($id))) {
            $physicist = $this->load->table_row('physicists');
            $physicist->load(intval($id));
            
            $this->parser->assign('phys', $physicist);
        }
		
        $this->parser->assign("year", $returnYear);
        $this->_addTemplateJs('physicist/index.js');
        $this->_assignTemplateAdditionals();
                
        $this->parser->setCacheId('physicist_detail_for_' + intval($id));
        $this->parser->parse("frontend/physicist.index.tpl");
    }  

}

?>
