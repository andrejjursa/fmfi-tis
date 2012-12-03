<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Images_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $description = gridField::newGridField();
        $description->setField('description')->setName('Popis')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($description);
        
        $file = gridField::newGridField();
        $file->setField('file')->setName('Obrázok')->setSortable(FALSE)->setType(GRID_FIELD_TYPE_IMAGE);
        $this->addGridField($file);
        
        $this->enableGrid(TRUE);
        $this->enableNewRecord(TRUE, 'Nový obrázok');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
        $this->setGridTableName('Obrázky');
    }
    
    protected function editorSettings() {
        $image = editorTab::getNewEditorTab();
        $image->setName('Obrázok');
        
        $field_description = new editorFieldText();
        $field_description->setField('description')->setFieldLabel('Popis')->setFieldHint('Sem zadajte popis pre obrázok.');
        $image->addField($field_description);        
        
        $field_file = new editorFieldFileUpload();
        $field_file->setField('file')->setFieldLabel('Obrázok')->setFieldHint('Vyberte súbor s obrázkom a nahrajte ho na server.');
        $field_file->setAllowedTypes('*.jpg;*.jpeg;*.png');
        $field_file->setMaxSize('3MB');
        $field_file->setUploadPath('public/uploads/images/');
        $field_file->setRules(array(
            'required' => TRUE,
            'messages' => array(
                'required' => 'Je nutné vybrať nejaký súbor s obrázkom.',
            ),
        ));
        $field_file->setUseFancybox(TRUE);
        $image->addField($field_file);
        
        $this->addEditorTab($image);
    }
    
}
