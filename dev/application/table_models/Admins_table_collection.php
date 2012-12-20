<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package TableModels
 */
class Admins_table_collection extends Abstract_table_collection {
    
    protected function gridSettings() {
        $this->enableGrid(TRUE);
        $this->enableNewRecord(TRUE, 'Vytvoriť nový účet administrátora');
        $this->enableEditRecord(TRUE);
        $this->enableDeleteRecord(TRUE);
        
        $email = gridField::newGridField();
        $email->setField('email')->setName('E-mail')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_TEXT);
        $this->addGridField($email);
        
        $this->load->model('admins');
        $excludet_ids = array(
            $this->admins->getAdminId(),
        );
        $this->setExcludetIds($excludet_ids);
        $this->setGridTableName('Administrátorské účty');
        $this->setDefaultSorting('email', 'asc');
    }

    protected function editorSettings() {
        
        $general = editorTab::getNewEditorTab();
        $general->setName('Administrátor');
        
        $field_email = new editorFieldText();
        $field_email->setField('email')->setFieldLabel('E-mail')->setFieldHint('Zadajte e-mailovú adresu administrátora, ktorá bude slúžiť aj ako jeho prihlasovacie meno.');
        $field_email->setRules(array(
            'required' => TRUE,
            'email' => TRUE,
            'remote_check' => createUri('admin', 'check_email'),
            'messages' => array(
                'required' => 'E-mailová adresa musí byť vyplnená.',
                'email' => 'Zadaná adresa nie je platná e-mailová adresa.',
                'remote_check' => 'E-mailovú adresu už používa iný účet.'
            ),
        ));
        $general->addField($field_email);
        
        $field_password = new editorFieldPassword();
        $field_password->setField('password')->setFieldLabel('Heslo')->setFieldHint('Vyplnte heslo. Pokial vytvárate nový účet, je nutné heslo vyplniť. Inak heslo vyplňte iba ak ho chcete zmeniť.');
        $field_password->setRules(array(
            'required_if_new' => TRUE,
            'rangelength' => array(6, 20),
            'messages' => array(
                'required_if_new' => 'Je nutné vyplniť heslo.',
                'rangelength' => 'Heslo musí byť v rozsahu {0} až {1} znakov.',
            ),
        ));
        $general->addField($field_password);
        
        $field_password_check = new editorFieldPassword();
        $field_password_check->setField('_password')->setFieldLabel('Heslo')->setFieldHint('Kontrola hore zadaného hesla.');
        $field_password_check->setRules(array(
            'equalTo' => '#' . $field_password->getFieldHtmlID(),
            'messages' => array(
                'equalTo' => 'Heslá sa nezhodujú.',
            ),
        ));
        $general->addField($field_password_check);
        
        $this->addEditorTab($general);
    }

}

?>