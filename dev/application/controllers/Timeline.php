<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Timeline extends Abstract_frontend_controller {

    public function index() {      
        $physicists = $this->load->table_collection('physicists');
        $physicists->filterOnlyDisplayed()->filterMinYear()->execute();
        $min_year = count($physicists->get()) ? $physicists->get()[0]->getBirth_year() : 0; 
        
        $this->parser->assign('min_year', $min_year);
        
        $data = $this->_getPhysicistsAndInventions($min_year);
        
        $this->parser->assign($data);
        
        $this->parser->parse('frontend/timeline.index.tpl');
    }
    
    public function ajaxUpdateList($year = NULL) {
        $data = $this->_getPhysicistsAndInventions($year);
        
        $output_data = array('physicists' => '', 'inventions' => '');
        
        $output_data['physicists'] = trim($this->parser->parse('partials/timeline.index.physicists.tpl', $data, TRUE));
        $output_data['inventions'] = trim($this->parser->parse('partials/timeline.index.inventions.tpl', $data, TRUE));
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output_data, JSON_PRETTY_PRINT));
    }
    
    public function _getPhysicistsAndInventions($year = NULL) {
        $physicists = $this->load->table_collection('physicists');
        
        $physicists->reset()->filterOnlyDisplayed()->filterLivedInYear(intval($year))->execute();
        $physicists = $physicists->get();
        
        $physicists_to_inventions = $this->load->table_relation('physicists', 'inventions');
        
        $inventions = $physicists_to_inventions->setOrderBy('year ASC')->getMultiple($physicists);
        
        return array('physicists' => $physicists, 'inventions' => $inventions);
    }

}

?>