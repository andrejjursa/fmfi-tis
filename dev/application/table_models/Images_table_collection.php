<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Images_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $description = gridField::newGridField();
        $description->setField('description')->setName('Popis')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($description);
        
        $file = gridField::newGridField();
        $file->setField('file')->setName('Obrázok')->setSortable(FALSE)->setType(GRID_FIELD_TYPE_IMAGE);
        $this->addGridField($file);
    }
    
}
