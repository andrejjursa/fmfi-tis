<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Questions_to_answers_table_relation extends Abstract_table_relation {

    public function __construct() {
        $this->relation_type_mm = FALSE;
        $this->foreign_table_name = 'answers';
        $this->foreign_index_field = 'question_id';
    }

}

?>