<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicists_table_collection extends Abstract_table_collection {
    
    /**
     * Adds filter for all physicists living in suplied year.
     * 
     * @param type $year year.
     * @return Physicists_table_collection reference back to this object.
     */
    public function filterLivedInYear($year) {
        $this->query->where('death_year >=', $year);
        $this->query->where('birth_year <=', $year);
        
        return $this;
    }
    
    /**
     * Adds filter to find one record with minimum birth_year value.
     * 
     * @return Physicists_table_collection reference back to this object.
     */
    public function filterMinYear() {
        $this->query->order_by('birth_year', 'ASC');
        $this->query->limit(1);
        
        return $this;
    }
    
    /**
     * Adds filter to find only displayed physicists records.
     * 
     * @return Physicists_table_collection reference back to this object.
     */
    public function filterOnlyDisplayed() {
        $this->query->where('displayed', '1');
        
        return $this;
    }
    
    /**
     * Settings for editing grid of admin panel.
     * 
     * @return void
     */
    protected function gridSettings() {
        $name = gridField::newGridField();
        $name->setField('name')->setName('Meno')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($name);
        
        $displayed = gridField::newGridField();
        $displayed->setField('displayed')->setName('Je zobraziteľný?')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_BOOL);
        $this->addGridField($displayed);
        
        $short_description = gridField::newGridField();
        $short_description->setField('short_description')->setName('Krátky popis')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_HTML);
        $this->addGridField($short_description);
        
        $photo = gridField::newGridField();
        $photo->setField('PhotoObject')->setName('Fotografia')->setSortable(FALSE)->setType(GRID_FIELD_TYPE_IMAGE);
        $photo_subfield = gridField::newGridField();
        $photo_subfield->setField('file');
        $photo->setSubField($photo_subfield);
        $this->addGridField($photo);
        
        $this->enableGrid();
        $this->setGridTableName('Fyzici');
        $this->enableNewRecord(TRUE, 'Pridať fyzika');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
        $this->enablePreviewRecord(TRUE);
    }
    
    protected function editorSettings() {
        $about = editorTab::getNewEditorTab();
        $about->setName('Všeobecné informácie');
        
        $field_displayed = new editorFieldSingleCheckbox();
        $field_displayed->setField('displayed')->setFieldLabel('Zobraziteľný')->setFieldHint('Zaškrtnite, ak má byť fyzik zobrazený na stránke.')
            ->setDefaultChecked(FALSE)->setDefaultValue(TRUE);
        $about->addField($field_displayed);
        
        $field_name = new editorFieldText();
        $field_name->setField('name')->setFieldLabel('Meno')->setFieldHint('Zadajte celé meno fyzika.')->setRules(array(
            'required' => TRUE,
            'messages' => array(
                'required' => 'Meno fyzika je vyžadované.',
            ),
        ));
        $about->addField($field_name);
        
        $field_birth_year = new editorFieldText();
        $field_birth_year->setField('birth_year')->setFieldLabel('Rok narodenia')->setFieldHint('Zadajte rok narodenia fyzika.')->setRules(array(
            'required' => true,
            'minlength' => 1,
            'maxlength' => 4,
            'digits' => true,
            'messages' => array(
                'required' => 'Rok narodenia je vyžadovaný.',
                'minlength' => 'Rok musí byť minimálne 1 číslicový.',
                'maxlength' => 'Rok musí byť maximálne 4 číslicový.',
                'digits' => 'Rok musí byť zadaný číselne.',
            ),
        ));
        $about->addField($field_birth_year);
        
        $field_is_dead = new editorFieldSingleCheckbox();
        $field_is_dead->setField('_is_dead')->setFieldLabel('Fyzik už zomrel')->setFieldHint('Označte, ak fyzik už zomrel.')->setDefaultChecked(FALSE)
            ->setCheckboxText('Áno')->setDefaultValue(1);
        $about->addField($field_is_dead);
        
        $field_death_year = new editorFieldText();
        $field_death_year->setField('death_year')->setFieldLabel('Rok úmrtia')->setFieldHint('Zadajte rok úmrtia fyzika.')->setRules(array(
            'required' => '#' . $field_is_dead->getFieldHtmlID() . ':checked',
            'minlength' => 1,
            'maxlength' => 4,
            'digits' => true,
            'greater_than' => '#' . $field_birth_year->getFieldHtmlID(),
            'messages' => array(
                'required' => 'Ak fyzik už zomrel, je treba vyplniť rok jeho úmrtia.',
                'minlength' => 'Rok musí byť minimálne 1 číslicový.',
                'maxlength' => 'Rok musí byť maximálne 4 číslicový.',
                'digits' => 'Rok musí byť zadaný číselne.',
                'greater_than' => 'Rok úmrtia musí byť väčšie číslo ako rok narodenia.',
            ),
        ));
        $about->addField($field_death_year);
        
        $this->addEditorTab($about);
        
        $texts = editorTab::getNewEditorTab();
        $texts->setName('Informácie');
        
        $field_description = new editorFieldTinymce();
        $field_description->setField('description')->setFieldLabel('Detailný text o fyzikovi')->setFieldHint('Sem vložte text popisujúci fyzikov život a prácu.')
            ->setRules(array('required' => true, 'messages' => array('required' => 'Je potrebné vyplniť túto položku.')));
        $texts->addField($field_description);
        
        $field_short_description = new editorFieldTinymce();
        $field_short_description->setField('short_description')->setFieldLabel('Skrátený text o fyzikovi')->setFieldHint('Sem vložte skrátený popis fyzika (bude na časovej osi).')
            ->setRules(array('required' => true, 'messages' => array('required' => 'Je potrebné vyplniť túto položku.')));
        $texts->addField($field_short_description);
        
        $this->addEditorTab($texts);
        
    }
}

?>