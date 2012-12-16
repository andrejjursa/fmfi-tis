<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Miniapp_files_table_row extends Abstract_table_row {
    
    protected function onDelete() {
        $file = trim($this->getFile(), '/');
        $this->load->helper('application');
        deleteImageAndThumbs($file);
    }

    
}

?>