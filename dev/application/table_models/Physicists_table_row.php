<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

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
     * Relation initialisations.
     */
    protected function init() {
        $this->questions = $this->load->table_relation('physicists', 'questions');
        $this->photo = $this->load->table_relation('physicists', 'one_image');
        $this->images = $this->load->table_relation('physicists', 'images');
        $this->inventions = $this->load->table_relation('physicists', 'inventions');
    }
    
    /**
     * Relation resets.
     */
    protected function resetRelations() {
        $this->questions->reset();
        $this->photo->reset();
        $this->images->Reset();
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
     * @return array<Abstract_table_row> related inventions.
     */
    public function getInventions() {
        return $this->inventions->get($this->getId());
    }
    
    public function prepareEditorSave($formdata) {
        if (!isset($formdata['displayed'])) { $formdata['displayed'] = '0'; }
        if (!isset($formdata['_is_dead'])) { $formdata['death_year'] = '9999'; }
        
        unset($formdata['_is_dead']);
        
        if (isset($formdata['inventions']) && $formdata['inventions'] != '0') {
            $inventions = explode(',', $formdata['inventions']);
            $this->inventions->setTo($this->getId(), $inventions);
        }
        unset($formdata['inventions']);
        
        if (isset($formdata['images']) && $formdata['images'] != '0') {
            $images = explode(',', $formdata['images']);
            $this->images->setTo($this->getId(), $images);
        }
        unset($formdata['images']);
        
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
        
        return $data;
    }
}

?>