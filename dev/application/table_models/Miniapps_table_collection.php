<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Miniapps_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $this->enableGrid(TRUE);
        $this->enableNewRecord(TRUE, 'Nová miniaplikácia');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
        $this->setGridTableName('Miniaplikácie');
        
        $name = gridField::newGridField();
        $name->setField('name')->setName('Názov')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($name);
    }
    
    protected function editorSettings() {
        
        $general = editorTab::getNewEditorTab();
        $general->setName('Všeobecná konfigurácia');
        
        $field_name = new editorFieldText();
        $field_name->setField('name')->setFieldLabel('Názov miniaplikácie')->setFieldHint('Zadajte názov miniaplikácie tak ako sa má zobraziť návštevníkom stránky.');
        $field_name->setRules(array(
            'required' => TRUE,
            'messages' => array(
                'required' => 'Názov miniaplikácie je vyžadovaný.',
            ),
        ));
        $general->addField($field_name);
        
        $field_headerhtml = new editorFieldMultilineText();
        $field_headerhtml->setField('headerhtml')->setFieldLabel('HTML obsah v hlavičke')->setFieldHint('Tento obsah sa vloží do <head> elementu stránky s miniaplikáciou.');
        $field_headerhtml->setNumberOfRows(10);
        $general->addField($field_headerhtml);
        
        $field_bodyhtml = new editorFieldMultilineText();
        $field_bodyhtml->setField('bodyhtml')->setFieldLabel('HTML obsah v tele')->setFieldHint('Tento obsah sa vloží do <body> elementu stránky s miniaplikáciou.');
        $field_bodyhtml->setNumberOfRows(10);
        $field_bodyhtml->setRules(array(
            'required' => TRUE,
            'messages' => array(
                'required' => 'Je nutné zadať HTML kód pre vloženie miniaplikácie do stránky.',
            ),
        ));
        $field_bodyhtml->setDefaultText('<p>Obsah miniaplikácie sa pripravuje.</p>');
        $general->addField($field_bodyhtml);
        
        $this->addEditorTab($general);
        
        $files = editorTab::getNewEditorTab();
        $files->setName('Súbory');
        
        $miniapp_files = new editorFieldIframeForeignRelation();
        $miniapp_files->setForeignTable('miniapp_files');
        $miniapp_files->setField('miniapp_files');
        $miniapp_files->setFieldLabel('Súbory miniaplikácie')->setFieldHint('Nahrajte potrebné súbory pre miniaplikáciu.');
        $miniapp_files->setMinimumHeight(280);
        $files->addField($miniapp_files);
        
        $this->addEditorTab($files);
        
    }
    
}

?>