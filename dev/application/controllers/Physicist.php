<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicist extends Abstract_frontend_controller {
    
    public function index($id = 1){
  		if (!$this->parser->isCached('frontend/physicist.index.tpl', 'physicist_detail_for_' + intval($id))) {
            $physicist = $this->load->table_row('physicists');
            $physicist->load(intval($id));
            
            $this->parser->assign('phys', $physicist);
        }
        
        $this->parser->setCacheId('physicist_detail_for_' + intval($id));
        $this->parser->parse("frontend/physicist.index.tpl");
    }  

}

?>
