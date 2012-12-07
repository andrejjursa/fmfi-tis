<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Images_table_row extends Abstract_table_row {
    
    /**
     * Delete file from images.
     * 
     * @return void
     */
    protected function onDelete() {
        $file = trim($this->getFile(), '/');
        $this->load->helper('application');
        deleteImageAndThumbs($file);
    }
    
}

?>