<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Questions_table_collection extends Abstract_table_collection {
    
    public function filterForPhysicist($physicist_id) {
        $this->query->where('physicist_id', intval($physicist_id));
        
        return $this;
    }
    
    public function gridSettings() {
        $this->enableNewRecord(TRUE, 'Vytvoriť otázku');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
    }
    
    public function editorSettings() {
        $question = editorTab::getNewEditorTab();
        $question->setName('Otázka');
        
        $field_question = new editorFieldTinymce();
        $field_question->setField('question')->setFieldLabel('Text otázky')->setFieldHint('Sem zadajte text otázky.');
        $field_question->setRules(array(
            'required_html' => true,
            'messages' => array(
                'required_html' => 'Je nutné aby bola otázka vyplnená.',
            ),
        ));
        $question->addField($field_question);
        
        $field_image = new editorFieldFileUpload();
        $field_image->setField('image')->setFieldLabel('Obrázok k otázke')->setFieldHint('Vložte obrázok ak ho otázka vyžaduje.');
        $field_image->setMaxSize('2MB')->setUploadPath('public/uploads/question_images')->setAllowedTypes('*.jpg; *.png; *.gif');
        $question->addField($field_image);
        
        $field_value = new editorFieldText();
        $field_value->setField('value')->setFieldLabel('Počet bodov za otázku')->setFieldHint('Zadajte počet bodov v rozsahu 1 až 10.');
        $field_value->setRules(array(
            'range' => array(1, 10),
            'required' => true,
            'digits' => true,
            'messages' => array(
                'range' => 'Rozsah bodov musí byť {0} až {1}.',
                'required' => 'Počet bodov je vyžadované zadať.',
                'digits' => 'Počet bodov môže byť iba číselná hodnota.',
            ),
        ));
        $question->addField($field_value);
        
        $field_physicist_id = new editorFieldParentIdRecord();
        $field_physicist_id->setField('physicist_id')->setParentTable('physicists');
        $field_physicist_id_else = new editorFieldMMRelation();
        $field_physicist_id_else->setField('physicist_id')->setFieldLabel('Fyzik')->setFieldHint('Vyberte fyzika, ktorému patrí táto otázka.');
        $field_physicist_id_else->setForeignTable('physicists')->setFilterInFields(array('name'))->setRules(array(
            'min_mm_items' => 1,
            'max_mm_items' => 1,
            'messages' => array(
                'min_mm_items' => 'Je nutné zvoliť jedného fyzika.',
                'max_mm_items' => 'Je nutné zvoliť jedného fyzika.',
            ),
        ));
        $field_physicist_id_else->setEditOnly(FALSE);
            $field_physicist_id_else_field_name = gridField::newGridField();
            $field_physicist_id_else_field_name->setField('name')->setName('Meno')->setType(GRID_FIELD_TYPE_TEXT);
        $field_physicist_id_else->addGridField($field_physicist_id_else_field_name);
        $field_physicist_id->setElseField($field_physicist_id_else);
        
        $question->addField($field_physicist_id);
        $this->addEditorTab($question);
        
        $answers = editorTab::getNewEditorTab();
        $answers->setName('Odpovede');
        
        $field_answers = new editorFieldIframeForeignRelation();
        $field_answers->setField('answers')->setFieldLabel('Odpovede')->setFieldHint('Vytvorte či upravde odpovede pre túto otázku.');
        $field_answers->setForeignTable('answers');
        $field_answers->setMinimumHeight(470);
        $answers->addField($field_answers);
        
        $this->addEditorTab($answers);
    }
    
}

?>