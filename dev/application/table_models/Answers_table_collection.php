<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Answers_table_collection extends Abstract_table_collection {
    
    public function filterForQuestion($question_id) {
        $this->query->where('question_id', intval($question_id));
        
        return $this;
    }
    
    public function gridSettings() {
        $this->enableNewRecord(TRUE, 'Vytvoriť odpoveď');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
    }
    
    public function editorSettings() {
        $answer = editorTab::getNewEditorTab();
        $answer->setName('Odpoveď');
        
        $field_answer = new editorFieldTinymce();
        $field_answer->setField('answer')->setFieldLabel('Text odpovede')->setFieldHint('Sem zadajte text odpovede.');
        $field_answer->setRules(array(
            'required_html' => true,
            'messages' => array(
                'required_html' => 'Je nutné aby bola odpoveď vyplnená.',
            ),
        ));
        $answer->addField($field_answer);
        
        $field_image = new editorFieldFileUpload();
        $field_image->setField('image')->setFieldLabel('Obrázok k odpovedi')->setFieldHint('Vložte obrázok ak ho odpoveď vyžaduje.');
        $field_image->setMaxSize('2MB')->setUploadPath('public/uploads/question_images')->setAllowedTypes('*.jpg; *.png; *.gif');
        $answer->addField($field_image);
        
        $field_correct = new editorFieldSingleCheckbox();
        $field_correct->setField('correct')->setFieldLabel('Je odpoveď správna?')->setFieldHint('Označte toto políčko ak má byť táto odpoveď správna.');
        $field_correct->setDefaultValue('1');
        $answer->addField($field_correct);
        
        $field_question_id = new editorFieldParentIdRecord();
        $field_question_id->setField('question_id')->setParentTable('questions');
        $field_question_id_else = new editorFieldMMRelation();
        $field_question_id_else->setField('question_id')->setFieldLabel('Otázka')->setFieldHint('Vyberte otázku, ktorej patrí táto odpoveď.');
        $field_question_id_else->setForeignTable('answers')->setFilterInFields(array('answer'))->setRules(array(
            'min_mm_items' => 1,
            'max_mm_items' => 1,
            'messages' => array(
                'min_mm_items' => 'Je nutné zvoliť jednu otázku.',
                'max_mm_items' => 'Je nutné zvoliť jednu otázku.',
            ),
        ));
        $field_question_id_else->setEditOnly(FALSE);
            $field_question_id_else_field_question = gridField::newGridField();
            $field_question_id_else_field_question->setField('question')->setName('Text otázky')->setType(GRID_FIELD_TYPE_HTML);
        $field_question_id_else->addGridField($field_question_id_else_field_question);
        $field_question_id->setElseField($field_question_id_else);
        
        $answer->addField($field_question_id);
        
        $this->addEditorTab($answer);
    }
    
}

?>