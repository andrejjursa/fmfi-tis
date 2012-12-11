<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package TableModels
 */
class Periods_table_collection extends Abstract_table_collection {
  

    public function gridSettings() {  
	
        $this->enableGrid(TRUE);
        $this->setGridTableName('Obdobia');
        $this->enableNewRecord(TRUE, 'Nové obdobie');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
        
        $name = gridField::newGridField();
        $name->setField('name')->setName('Názov obdobia')->setType(GRID_FIELD_TYPE_TEXT)->setSortable(TRUE);
        $this->addGridField($name);
        
        
        $description = gridField::newGridField();
        $description->setField('description')->setName('Popis obdobia')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_HTML);
        $this->addGridField($description);
		
		$image = gridField::newGridField();
        $image->setField('image')->setName('Obrázok')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_IMAGE);
        $this->addGridField($image);

		$start_year = gridField::newGridField();
        $start_year->setField('start_year')->setName('Začiatok obdobia')->setType(GRID_FIELD_TYPE_NUMBER)->setSortable(TRUE);
        $this->addGridField($start_year);
		
		$end_year = gridField::newGridField();
        $end_year->setField('end_year')->setName('Koniec obdobia')->setType(GRID_FIELD_TYPE_NUMBER)->setSortable(TRUE);
        $this->addGridField($end_year);

    }
    
    protected function editorSettings() {
        $general = editorTab::getNewEditorTab();
        $general->setName('Všeobecné informácie');
        
        
        $field_name = new editorFieldText();
        $field_name->setField('name')->setFieldLabel('Názov obdobia')->setFieldHint('Zadajte názov obdobia.');
        $field_name->setRules(array(
            'required' => true,
            'messages' => array(
                'required' => 'Je nutné zadať názov obdobia.',
            ),
        ));
        $general->addField($field_name);   
        
        $field_start_year = new editorFieldText();
        $field_start_year->setField('start_year')->setFieldLabel('Začiatok obdobia (rok)')->setFieldHint('Zadajte rok, v ktorom sa začalo toto obdobie.');
        $field_start_year->setRules(array(
            'required' => true,
            'range' => array(-9999, 9999),
            'messages' => array(
                'required' => 'Je nutné zadať rok začiatku obdobia.',
                'range' => 'Rok musí byť číslo v rozsahu od {0} do {1}.',
            ),
        ));     
        $general->addField($field_start_year);
		
  
        $field_end_year = new editorFieldText();
        $field_end_year->setField('end_year')->setFieldLabel('Koniec obdobia (rok)')->setFieldHint('Zadajte rok, v ktorom sa skončilo toto obdobie.');
        $field_end_year->setRules(array(
            'required' => true,
            'range' => array(-9999, 9999),
            'messages' => array(
                'required' => 'Je nutné zadať rok konca obdobia.',
                'range' => 'Rok musí byť číslo v rozsahu od {0} do {1}.',
            ),
        ));     
        $general->addField($field_end_year);		
        
        $this->addEditorTab($general);
        
        $texts = editorTab::getNewEditorTab();
        $texts->setName('Informácie');
        
        $field_description = new editorFieldTinymce();
        $field_description->setField('description')->setFieldLabel('Detailný text o období')->setFieldHint('Sem vložte text popisujúci obdobie.')
            ->setRules(array('required' => true, 'messages' => array('required' => 'Je potrebné vyplniť túto položku.')));
        $texts->addField($field_description);
                
        $this->addEditorTab($texts);
        
        $img = editorTab::getNewEditorTab();
        $img->setName('Pozadie');
        
        $field_image = new editorFieldFileUpload();
        $field_image->setField('image')->setFieldLabel('Obrázok pozadia')->setFieldHint('Vyberte súbor s obrázkom a nahrajte ho na server.');
        $field_image->setAllowedTypes('*.jpg;*.jpeg;*.png');
        $field_image->setMaxSize('1MB');
        $field_image->setUploadPath('public/uploads/periods/');
        $field_image->setUseFancybox(TRUE);
        $field_image->setRules(array(
            'required' => TRUE,
            'messages' => array(
                'required' => 'Je nutné vybrať nejaký súbor s obrázkom.',
            ),
        ));
        $img->addField($field_image);
        
        $field_bg_color = new editorFieldColorPicker();
        $field_bg_color->setField('bg_color')->setFieldLabel('Farba pozadia')->setFieldHint('Zadajte farbu pozadia posuvníka časovej osi.');
        $field_bg_color->setDefaultColor('#000000');
        $img->addField($field_bg_color);
        
        $field_number_color = new editorFieldColorPicker();
        $field_number_color->setField('number_color')->setFieldLabel('Farba číselnej osi')->setFieldHint('Zadajte farbu číselnej osi na časovej osi.');
        $field_number_color->setDefaultColor('#ffffff');
        $img->addField($field_number_color);
                
        $this->addEditorTab($img);
        
        $physicists = editorTab::getNewEditorTab();
        $physicists->setName('Fyzici');
        
        $field_physicists = new editorFieldMMRelation();
        $field_physicists->setField('physicists')->setFieldLabel('Fyzici tohoto obdobia')->setFieldHint('Vyberte fyzikov tohoto obdobia.');
        $field_physicists->setEditOnly(TRUE);
        $field_physicists->setForeignTable('physicists');
        $field_physicists->setFilterInFields(array('name', 'description', 'short_description'));
            $field_physicists_photo = gridField::newGridField();
            $field_physicists_photo_sub = gridField::newGridField();
            $field_physicists_photo_sub->setField('file');
            $field_physicists_photo->setField('PhotoObject')->setType(GRID_FIELD_TYPE_IMAGE)->setName('Fotka')->setWidth('25%');
            $field_physicists_photo->setSubField($field_physicists_photo_sub);
        $field_physicists->addGridField($field_physicists_photo);
            $field_physicists_name = gridField::newGridField();
            $field_physicists_name->setField('name')->setType(GRID_FIELD_TYPE_TEXT)->setName('Meno');
        $field_physicists->addGridField($field_physicists_name);
        $physicists->addField($field_physicists);
        
        $this->addEditorTab($physicists);
        
        $inventions = editorTab::getNewEditorTab();
        $inventions->setName('Objavy');
        
        $field_inventions = new editorFieldMMRelation();
        $field_inventions->setField('inventions')->setFieldLabel('Fyzici tohoto obdobia')->setFieldHint('Vyberte fyzikov tohoto obdobia.');
        $field_inventions->setEditOnly(TRUE);
        $field_inventions->setForeignTable('inventions');
        $field_inventions->setFilterInFields(array('name', 'description', 'short_description'));
            $field_inventions_photo = gridField::newGridField();
            $field_inventions_photo_sub = gridField::newGridField();
            $field_inventions_photo_sub->setField('file');
            $field_inventions_photo->setField('PhotoObject')->setType(GRID_FIELD_TYPE_IMAGE)->setName('Obrázok')->setWidth('25%');
            $field_inventions_photo->setSubField($field_inventions_photo_sub);
        $field_inventions->addGridField($field_inventions_photo);
            $field_inventions_name = gridField::newGridField();
            $field_inventions_name->setField('name')->setType(GRID_FIELD_TYPE_TEXT)->setName('Názov');
        $field_inventions->addGridField($field_inventions_name);
        $inventions->addField($field_inventions);
        
        $this->addEditorTab($inventions);

    }
    
}
