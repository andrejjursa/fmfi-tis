<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicists_table_row extends Abstract_table_row {
    
    /**
     * var Abstract_table_relation relation to questions for this physicist.
     */
    protected $questions;
    
    /**
     * Relation initialisations.
     */
    protected function init() {
        $this->questions = $this->load->table_relation('physicists', 'questions');
    }
    
    /**
     * Relation resets.
     */
    protected function resetRelations() {
        $this->questions->reset();
    }
    
    /**
     * Get all related questions in order given by storage engine.
     */
    public function getQuestions() {
        return $this->questions->setOrderBy(NULL)->get($this->getId());
    }
    
    /**
     * Get all related questions in random order.
     */
    public function getQuestionsRandom() {
        return $this->questions->setOrderBy('random')->get($this->getId());
    }
    
}

?>