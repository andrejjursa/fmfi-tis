<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Timeline extends Abstract_frontend_controller {

    /**
     * Displays page with timeline. Year on timeline will be set to its minimum as well
     * as list of physicists and inventions from this minimum year.
     */
    public function index() {      
        $physicists = $this->load->table_collection('physicists');
        $physicists->filterOnlyDisplayed()->filterMinYear()->execute();
        $year = count($physicists->get()) ? $physicists->get()[0]->getBirth_year() : 0; 
        
        $this->parser->assign('year', intval($year));
        
        $data = $this->_getPhysicistsAndInventions($year);
        
        $this->parser->assign($data);
        
        $this->_addTemplateDynamicJs('timeline', array(
            'start_year' => $year,
            'end_year' => date('Y')
        ));
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('frontend/timeline.index.tpl');
    }
    
    /**
     * Takes year as parameter and returns JSON representation of rendered partials for
     * physicists and inventions.
     * 
     * @param integer $year year for which data have to be fetched from database.
     */
    public function ajaxUpdateList($year = NULL) {
        $data = $this->_getPhysicistsAndInventions($year);
        $data['year'] = $year;
        
        $output_data = array('physicists' => '', 'inventions' => '');
        
        $output_data['physicists'] = trim($this->parser->parse('partials/timeline.index.physicists.tpl', $data, TRUE));
        $output_data['inventions'] = trim($this->parser->parse('partials/timeline.index.inventions.tpl', $data, TRUE));
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($output_data, JSON_PRETTY_PRINT));
    }
    
    /**
     * Returns physicists and inventions from database for given year.
     * 
     * @param integer $year year, again ...
     * @return array<mixed> physicists and inventions.
     */
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