<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Physicists_to_one_image_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->relation_type_mm = FALSE;
        $this->foreign_table_name = 'images';
    }
    
}
    
?>