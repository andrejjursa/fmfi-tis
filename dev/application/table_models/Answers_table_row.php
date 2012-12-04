<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Answers_table_row extends Abstract_table_row {
    
    protected function onDelete() {
        if ($this->getImage()) {
            $this->load->helper('application');
            deleteImageAndThumbs($this->getImage());
        }
    }
    
}

?>