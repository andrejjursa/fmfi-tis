<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
/**
 * @package TableModels
 */
class Physicists_to_images_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->relation_type_mm = TRUE;
        $this->mm_table_name = 'physicists_images_mm';
        $this->mm_local_id_field = 'physicist_id';
        $this->mm_foreign_id_field = 'image_id';
        $this->foreign_table_name = 'images';
    }
    
}
    
?>