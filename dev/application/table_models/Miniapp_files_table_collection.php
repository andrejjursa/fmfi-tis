<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Miniapp_files_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $this->setGridTableName('Súbory miniaplikácií');
        $this->enableNewRecord(TRUE);
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
    }

    protected function editorSettings() {
        
        $file = editorTab::getNewEditorTab();
        $file->setName('Súbor');
        
        $field_file = new editorFieldFileUpload();
        $field_file->setField('file')->setFieldLabel('Súbor')->setFieldHint('Nahrajte súbor potrebný pre miniaplikáciu.');
        $field_file->setAllowedTypes('*.jar; *.swf; *.css; *.js; *.jpg; *.jpeg; *.gif; *.png; *.xml');
        $field_file->setShowFilePath(TRUE);
        $field_file->setRules(array(
            'required' => TRUE,
            'messages' => array(
                'required' => 'Súbor je potrebné nahrať.',
            ),
        ));
        $field_file->setMaxSize('10MB');
        $field_file->setUploadPath('public/uploads/miniapps');
        $file->addField($field_file);
        
        $field_miniapp_id = new editorFieldParentIdRecord();
        $field_miniapp_id->setField('miniapp_id');
        $field_miniapp_id->setParentTable('miniapps');
        $field_miniapp_id_else = new editorFieldMMRelation();
        $field_miniapp_id_else->setFilterInFields(array('name'))->setForeignTable('miniapps')->setField('miniapp_id')->setFieldLabel('Miniaplikácia')->setFieldHint('Vyberte miniaplikáciu, ktorej patrí tento súbor.');
        $field_miniapp_id_else->setEditOnly(FALSE);
            $field_miniapp_id_else_name = gridField::newGridField();
            $field_miniapp_id_else_name->setField('name')->setName('Názov miniaplikácie')->setType(GRID_FIELD_TYPE_TEXT);
        $field_miniapp_id_else->addGridField($field_miniapp_id_else_name);
        $field_miniapp_id_else->setRules(array(
            'required' => TRUE,
            'min_mm_items' => 1,
            'max_mm_items' => 1,
            'messages' => array(
                'requited' => 'Je nutná vybrať cieľovú miniaplikáciu',
                'min_mm_items' => 'Musí byť zvolená jedna cieľová miniaplikácia.',
                'max_mm_items' => 'Cieľová miniaplikácia môže byť iba jedna.'
            ),
        ));
        $field_miniapp_id->setElseField($field_miniapp_id_else);
        $file->addField($field_miniapp_id);
        
        $this->addEditorTab($file);
        
    }

}

?>