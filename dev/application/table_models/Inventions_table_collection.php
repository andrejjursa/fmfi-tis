<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Inventions_table_collection extends Abstract_table_collection {

	/**
	 * @return Inventions_table_collection 
	 */
	public function filterOnlyDisplayed(){
		$this->query->where("displayed", 1);
        return $this;
	}
	
    public function filterByPhysicistId($id){
        //WTF???
    }
    
    public function gridSettings() {
        $this->enableGrid(TRUE);
        $this->setGridTableName('Objavy');
        $this->enableNewRecord(TRUE, 'Nový objav');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
        
        $name = gridField::newGridField();
        $name->setField('name')->setName('Názov objavu')->setType(GRID_FIELD_TYPE_TEXT)->setSortable(TRUE);
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
    }
    
    public function editorSettings() {
        $general = editorTab::getNewEditorTab();
        $general->setName('Všeobecné informácie');
        
        $field_displayed = new editorFieldSingleCheckbox();
        $field_displayed->setField('displayed')->setFieldLabel('Zobraziteľný')->setFieldHint('Zaškrtnite, ak má byť fyzik zobrazený na stránke.')
            ->setDefaultChecked(FALSE)->setDefaultValue(TRUE);
        $general->addField($field_displayed);
        
        $field_name = new editorFieldText();
        $field_name->setField('name')->setFieldLabel('Názov objavu')->setFieldHint('Zadajte názov objavu.');
        $field_name->setRules(array(
            'required' => true,
            'messages' => array(
                'required' => 'Je nutné zadať názov objavu.',
            ),
        ));
        $general->addField($field_name);   
        
        $field_year = new editorFieldText();
        $field_year->setField('year')->setFieldLabel('Rok objavu')->setFieldHint('Zadajte rok, v ktorom bol objav uskutočnený.');
        $field_year->setRules(array(
            'required' => true,
            'range' => array(-9999, 9999),
            'messages' => array(
                'required' => 'Je nutné zadať rok objavu.',
                'range' => 'Rok musí byť číslo v rozsahu od {0} do {1}.',
            ),
        ));     
        $general->addField($field_year);
        
        $this->addEditorTab($general);
        
        $texts = editorTab::getNewEditorTab();
        $texts->setName('Informácie');
        
        $field_description = new editorFieldTinymce();
        $field_description->setField('description')->setFieldLabel('Detailný text o objave')->setFieldHint('Sem vložte text popisujúci objav.')
            ->setRules(array('required' => true, 'messages' => array('required' => 'Je potrebné vyplniť túto položku.')));
        $texts->addField($field_description);
        
        $field_short_description = new editorFieldTinymce();
        $field_short_description->setField('short_description')->setFieldLabel('Skrátený text o objave')->setFieldHint('Sem vložte skrátený popis objavu (bude na časovej osi).')
            ->setRules(array('required' => true, 'messages' => array('required' => 'Je potrebné vyplniť túto položku.')));
        $texts->addField($field_short_description);
        
        $this->addEditorTab($texts);
        
        $photo_images = editorTab::getNewEditorTab();
        $photo_images->setName('Fotka a obrázky');
        
        $field_photo = new editorFieldMMRelation();
        $field_photo->setField('photo')->setFieldLabel('Fotografia')->setFieldHint('Vyberte jeden obrázok ako fotografiu tohoto objavu.');
        $field_photo->setFilterInFields(array('description', 'file'))->setForeignTable('images');
            $photo_field_file = gridField::newGridField();
            $photo_field_file->setField('file')->setType(GRID_FIELD_TYPE_IMAGE)->setName('Obrázok')->setWidth('100px');
        $field_photo->addGridField($photo_field_file);
            $photo_field_description = gridField::newGridField();
            $photo_field_description->setField('description')->setType(GRID_FIELD_TYPE_TEXT)->setName('Popis');
        $field_photo->addGridField($photo_field_description);
        $field_photo->setRules(array(
            'min_mm_items' => 1,
            'max_mm_items' => 1,
            'messages' => array(
                'min_mm_items' => 'Je potrebné vybrať jednu fotografiu.',
                'max_mm_items' => 'Je potrebné vybrať jednu fotografiu.',
            ),
        ));
        $field_photo->setEditOnly(FALSE);
        $photo_images->addField($field_photo);
        
        $field_images = new editorFieldMMRelation();
        $field_images->setField('images')->setFieldLabel('Obrázky')->setFieldHint('Vyberte obrázky pre tento objav.');
        $field_images->setFilterInFields(array('description', 'file'))->setForeignTable('images');
            $images_field_file = gridField::newGridField();
            $images_field_file->setField('file')->setType(GRID_FIELD_TYPE_IMAGE)->setName('Obrázok')->setWidth('100px');
        $field_images->addGridField($images_field_file);
            $images_field_description = gridField::newGridField();
            $images_field_description->setField('description')->setType(GRID_FIELD_TYPE_TEXT)->setName('Popis');
        $field_images->addGridField($images_field_description);
        $photo_images->addField($field_images);
        
        $this->addEditorTab($photo_images);
        
        $miniapps = editorTab::getNewEditorTab();
        $miniapps->setName('Miniaplikácie');
        
        $field_miniapps = new editorFieldMMRelation();
        $field_miniapps->setField('miniapps')->setFieldLabel('Miniaplikácie')->setFieldHint('Vyberte miniaplikácie k tomuto objavu.');
        $field_miniapps->setForeignTable('miniapps');
        $field_miniapps->setEditOnly(TRUE);
        $field_miniapps_name = gridField::newGridField();
        $field_miniapps_name->setField('name')->setName('Názov miniaplikácie')->setType(GRID_FIELD_TYPE_TEXT);
        $field_miniapps->addGridField($field_miniapps_name);
        $field_miniapps->setFilterInFields(array('name'));
        $miniapps->addField($field_miniapps);
        
        $this->addEditorTab($miniapps);
    }
    
}