<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Timeline extends Abstract_frontend_controller {

    public function index() {      
        $physicists = $this->load->table_collection('physicists');
        $physicists->filterOnlyDisplayed()->filterMinYear()->execute();
        $min_year = count($physicists->get()) ? $physicists->get()[0]->getBirth_year() : 0; 
        
        $this->parser->assign('min_year', $min_year);
        
        $physicists->reset()->filterOnlyDisplayed()->filterLivedInYear($min_year)->execute();
        $default_physicists = $physicists->get();
        $default_physicists_ids = $physicists->allIds();
        
        $this->parser->assign('default_physicists', $default_physicists);
        
        $physicists_to_inventions = $this->load->table_relation('physicists', 'inventions');
        
        $default_inventions = $physicists_to_inventions->setOrderBy('year ASC')->getMultiple($default_physicists_ids);
        
        $this->parser->assign('default_inventions', $default_inventions);
        
        $this->parser->parse('frontend/timeline.index.tpl');
    }
    
    public function ajaxUpdateList($year = NULL) {
        echo json_encode(array('test' => '<test>tst</test>'), JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
        $physicists_objects = $this->load->table_collection('physicists')->execute()->get();
        $physicists_arrays = array();
        foreach ($physicists_objects as $physicist) {
            $physicists_arrays[] = $physicist->data();
        }
        echo json_encode(array('collection' => $physicists_arrays), JSON_PRETTY_PRINT);
    }

}

?>