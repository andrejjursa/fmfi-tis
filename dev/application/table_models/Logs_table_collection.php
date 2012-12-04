<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logs_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $this->enableGrid(TRUE);
        $this->setGridTableName('Záznamy udalostí');
        $this->enablePreviewRecord(TRUE);
    }
    
}

?>