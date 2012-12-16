<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Physicists_table_row extends Abstract_table_row {
    
    /**
     * @var Abstract_table_relation relation to questions for this physicist.
     */
    protected $questions;
    
    /**
     * @var Abstract_table_relation relation to one photo image.
     */
    protected $photo;
    
    /**
     * @var Abstract_table_relation relation to images for this physicist.
     */
    protected $images;
    
    /**
     * @var Abstract_table_relation relation to inventions.
     */
    protected $inventions;
    
    /**
     * @var Abstract_table_relation relation to periods.
     */
    protected $periods;
    
    /**
     * @var Abstract_table_relation relation to miniapps.
     */
    protected $miniapps;
    
    /**
     * Relation initialisations.
     */
    protected function init() {
        $this->questions = $this->load->table_relation('physicists', 'questions');
        $this->photo = $this->load->table_relation('physicists', 'one_image');
        $this->images = $this->load->table_relation('physicists', 'images');
        $this->inventions = $this->load->table_relation('physicists', 'inventions');
        $this->periods = $this->load->table_relation('physicists', 'periods');
        $this->miniapps = $this->load->table_relation('physicists', 'miniapps');
    }
    
    /**
     * Relation resets.
     */
    protected function resetRelations() {
        $this->questions->reset();
        $this->photo->reset();
        $this->images->reset();
        $this->inventions->Reset();
        $this->periods->reset();
        $this->miniapps->reset();
    }
    
    /**
     * Get all related questions in order given by storage engine.
     * 
     * @return array<Abstract_table_row> questions in storage engine order.
     */
    public function getQuestions() {
        return $this->questions->setOrderBy(NULL)->get($this->getId());
    }
    
    /**
     * Get all related questions in random order.
     * 
     * @return array<Abstract_table_row> questions in random order.
     */
    public function getQuestionsRandom() {
        return $this->questions->setOrderBy('random')->get($this->getId());
    }
    
    /**
     * Get related photo image row.
     * 
     * @return Abstract_table_row image row.
     */
    public function getPhotoObject() {
        $photos = $this->photo->get($this->getId(), $this->getPhoto());
        if (count($photos)) { return $photos[0]; }
        return $this->load->table_row('images');
    }
    
    /**
     * Get all related images for this physicist.
     * 
     * @return array<Abstract_table_row> related images.
     */
    public function getImages() {
        return $this->images->get($this->getId());
    }
    
    /**
     * Get all related inventions for this physicist.
     * 
     * @param boolean $displayed_only displays only displayed invention or all (hidden as well).
     * @return array<Abstract_table_row> related inventions.
     */
    public function getInventions($displayed_only = FALSE) {
        if ($displayed_only) {
            $this->inventions->setWhere('inventions.displayed = ?', array(1));
        } else {
            $this->inventions->setWhere(NULL);
        }
        return $this->inventions->setOrderBy('name')->get($this->getId());
    }
    
    /**
     * Returns all periods.
     * 
     * @return array<Abstract_table_row> periods.
     */
    public function getPeriods() {
        return $this->periods->get($this->getId()); 
    }
    
    /**
     * Check if this physicist belongs to given period.
     * 
     * @return boolean TRUE if belongs.
     */
    public function getBelongsToPeriod($period) {
        return in_array($period, $this->periods->allIds($this->getId()));
    }
    
    /**
     * Returns all miniapps.
     * 
     * @return array<Abstract_table_row> miniapps.
     */
    public function getMiniapps() {
        return $this->miniapps->setOrderBy('name')->get($this->getId());
    }
    
    public function prepareEditorSave($formdata) {
        if (!isset($formdata['displayed'])) { $formdata['displayed'] = '0'; }
        if (!isset($formdata['_is_dead'])) { $formdata['death_year'] = '9999'; }
        
        unset($formdata['_is_dead']);
        
        $this->load->helper('application');
        
        if (isset($formdata['inventions'])) {
            $inventions = expandRelationListToArray($formdata['inventions']);
            $this->inventions->setTo($this->getId(), $inventions);
        }
        unset($formdata['inventions']);
        
        if (isset($formdata['images'])) {
            $images = expandRelationListToArray($formdata['images']);
            $this->images->setTo($this->getId(), $images);
        }
        unset($formdata['images']);
        
        if (isset($formdata['miniapps'])) {
            $miniapps = expandRelationListToArray($formdata['miniapps']);
            $this->miniapps->setTo($this->getId(), $miniapps);
        }
        unset($formdata['miniapps']);
        
        $this->data($formdata);
    }
    
    public function getDataForEditor() {
        $data = $this->data();
        
        if (isset($data['death_year']) && intval($data['death_year']) < 9999) {
            $data['_is_dead'] = TRUE;
        } else if (isset($data['death_year']) && intval($data['death_year']) >= 9999) {
            $data['_is_dead'] = FALSE;
            unset($data['death_year']);
        }
        
        $data['inventions'] = implode(',', $this->inventions->allIds($this->getId()));
        $data['images'] = implode(',', $this->images->allIds($this->getId()));
        $data['questions'] = $this->questions->allIds($this->getId());
        $data['miniapps'] = implode(',', $this->miniapps->allIds($this->getId()));
        
        return $data;
    }
    
    protected function onDelete() {
        $this->inventions->deleteAll($this->getId());
        $this->images->deleteAll($this->getId());
        
        $questions = $this->questions->setOrderBy()->get($this->getId());
        if (count($questions)) {
            foreach($questions as $question) {
                $question->delete();
            }
        }
    }
}

?>