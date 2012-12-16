<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Physicist extends Abstract_frontend_controller {
    
    public function index($id = 1, $year = 0, $period = 0){
		$physicist = $this->load->table_row('physicists');
		$physicist->load(intval($id));

		$this->parser->assign('phys', $physicist);
		$this->parser->assign("inventions", $physicist->getInventions(TRUE));
        $this->parser->assign("year", $year);
		$this->parser->assign("current_period", $period);
        $this->_addTemplateJs('physicist/index.js');
        $this->_assignTemplateAdditionals();
                
        $this->parser->parse("frontend/physicist.index.tpl");
    }  

}

?>
