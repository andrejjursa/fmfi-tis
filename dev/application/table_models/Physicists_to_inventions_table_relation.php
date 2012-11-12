<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Physicists_to_inventions_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->relation_type_mm = TRUE;
        $this->mm_table_name = 'inventions_physicists_mm';
        $this->mm_local_id_field = 'physicist_id';
        $this->mm_foreign_id_field = 'invention_id';
        $this->foreign_table_name = 'inventions';
    }
    
}
    
?>