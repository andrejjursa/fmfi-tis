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
     * Relation initialisations.
     */
    protected function init() {
        $this->questions = $this->load->table_relation('physicists', 'questions');
        $this->photo = $this->load->table_relation('physicists', 'one_image');
        $this->images = $this->load->table_relation('physicists', 'images');
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
    
}

?>