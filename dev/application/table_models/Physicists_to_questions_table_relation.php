<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicists_to_questions_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->foreign_table_name = 'questions';
        $this->foreign_index_field = 'physicist_id';
        $this->relation_type_mm = FALSE;
    }
    
}

?>