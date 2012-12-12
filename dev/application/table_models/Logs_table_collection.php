<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package TableModels
 */
class Logs_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $this->enableGrid(TRUE);
        $this->setGridTableName('Záznamy udalostí');
        $this->enablePreviewRecord(TRUE);
        $this->setDefaultSorting('crdate', 'desc');
        
        $message = gridField::newGridField();
        $message->setField('message')->setSortable(TRUE)->setName('Správa')->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($message);
        
        $admin = gridField::newGridField();
        $admin->setField('AdminEmail')->setSortable(TRUE)->setName('Administrátor')->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($admin);
    }
    
}

?>