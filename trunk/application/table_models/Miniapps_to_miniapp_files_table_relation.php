<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Miniapps_to_miniapp_files_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->relation_type_mm = FALSE;
        $this->foreign_index_field = 'miniapp_id';
        $this->foreign_table_name = 'miniapp_files';
    }

}

?>