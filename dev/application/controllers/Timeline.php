<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Timeline extends Abstract_frontend_controller {

    /**
     * Displays page with timeline. Year on timeline will be set to its minimum as well
     * as list of physicists and inventions from this minimum year.
     */
    public function index($year = NULL) {
		
        $physicists = $this->load->table_collection('physicists');
		$physicists->filterOnlyDisplayed()->filterMinYear()->execute();
		$phisicists_list = $physicists->get();
		$minYear = count($phisicists_list) ? $phisicists_list[0]->getBirth_year() : 0;
        
		if($year === NULL){
			$year = $minYear;
		}
		$year = (int) $year;
		
        $this->parser->assign('year', $year);
        $this->parser->assign('max_year', date('Y'));
		$this->parser->assign('min_year', $minYear);
        
		$this->parser->disable_caching();
		
        $data = $this->_getPhysicistsAndInventions($year);
        
        $this->parser->assign($data);
        
        $this->_addTemplateDynamicJs('timeline', array(
            'start_year' => $minYear,
			'year' => $year,
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
        $this->output->set_output(json_encode($output_data));
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
    
    /**
     * Creates and return JSON array of object representing each physicist name and both birth and
     * death year in chronological order.
     */
    public function ajaxTimelineInfoData() {
        $physicists = $this->load->table_collection('physicists');
        $physicists->filterOnlyDisplayed()->orderBy('birth_year', 'asc')->execute();
        
        $list = $physicists->get();
        $data = array();
        
        if (count($list)) {
            foreach($list as $item) {
                $row = array();
                $row['name'] = $item->getName();
                $row['birth_year'] = $item->getBirth_year();
                $row['death_year'] = $item->getDeath_year();
                $data[] = $row;
            }
        }
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data));
    }
    
}

?>