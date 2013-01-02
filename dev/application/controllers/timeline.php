<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Timeline extends Abstract_frontend_controller {

    /**
     * Constructor for loading common stuff.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('timeline');
    }

    /**
     * Displays page with timeline. Year on timeline will be set to its minimum as well
     * as list of physicists and inventions from this minimum year.
     */
    public function index($year = -1, $period = NULL) {
        $periods_table = $this->load->table_collection('periods');
        $periods_table->orderBy('start_year', 'asc')->execute();
        
        $periods = $periods_table->get();
        $current_period = (!is_null($period) && $period > 0) ? intval($period) : intval(@$periods[0]->getId());
        
        $this->parser->assign('periods', $periods);
        $this->parser->assign('current_period', $current_period);
        
        $current_period_table = $this->load->table_row('periods');
        $current_period_table->load($current_period);
        
        $minYear = $current_period_table->getStart_year();
        $maxYear = $current_period_table->getEnd_year();
        $maxYear = $maxYear >= 9999 ? date('Y') : $maxYear;
		
		$year = (int) $year;
		if($year < $minYear || $year > $maxYear){
			$year = $maxYear;
		}
		
        $this->parser->assign('year', $year);
        $this->parser->assign('max_year', $maxYear);
		$this->parser->assign('min_year', $minYear);
        
		$this->parser->disable_caching();
		
        $data = $this->_getPhysicistsAndInventions($year, $current_period);
        
        $this->parser->assign($data);
        
        $slider_background = createSlidebBackgroundImage($current_period_table->getImage(), $minYear, $maxYear, $current_period_table->getBg_color(), $current_period_table->getNumber_color(), 14, 400);
        
        $this->_addTemplateDynamicJs('timeline', array(
            'start_year' => $minYear,
			'year' => $year,
            'end_year' => $maxYear,
            'period' => $current_period,
        ));
        $this->_assignTemplateAdditionals();
        
        $this->parser->assign('slider_background', $slider_background);
        
        $this->parser->assign('dataForJS', array(
            'background' => $slider_background,
            'number_color' => $current_period_table->getNumber_color(),
            'border_color' => $current_period_table->getBorder_color(),
        ));
        
        $this->parser->parse('frontend/timeline.index.tpl');
    }
    
    /**
     * Takes year as parameter and returns JSON representation of rendered partials for
     * physicists and inventions.
     * 
     * @param integer $year year for which data have to be fetched from database.
     */
    public function ajaxUpdateList($year = NULL, $period = NULL) {
        $data = $this->_getPhysicistsAndInventions($year);
        $data['year'] = $year;
        $data['current_period'] = $period;
        
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
    public function _getPhysicistsAndInventions($year = NULL, $period = NULL) {
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
    public function ajaxTimelineInfoData($period = NULL) {
        $physicists = $this->load->table_collection('physicists');
        $physicists->filterOnlyDisplayed()->orderBy('birth_year', 'asc')->execute();
        
        $list = $physicists->get();
        $data = array();
        
        if (count($list)) {
            foreach($list as $item) {
                if ($item->getBelongsToPeriod(intval($period))) {
                    $row = array();
                    $row['name'] = $item->getName();
                    $row['birth_year'] = $item->getBirth_year();
                    $row['death_year'] = $item->getDeath_year();
                    $data[] = $row;
                }
            }
        }
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($data));
    }
    
}

?>