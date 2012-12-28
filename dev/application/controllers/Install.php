<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Install extends My_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('migration');
        $this->load->model('configurator');
        $this->load->helper('url');
        
        $this->parser->assign('site_base_url', $this->getBaseDir());
        
        $this->load->library('session');
        
        $this->parser->assign('steps', array(
            'welcome' => 'Úvod',
            'database' => 'Databáza',
            'adminacc' => 'Administrátor',
            'config' => 'Konfigurácia',
            'finish' => 'Hotovo',
        ));
    }

    public function index() {
        $this->parser->assign('flash_message', $this->session->flashdata('flash_message'));
        $this->parser->assign('current_step', 'welcome');
        $this->parser->assign('legend', 'Vitajte v inštalácii');
        $this->configurator->setConfigArray('config', array('encryption_key' => $this->getRandomEncryptionKey(), 'base_url' => $this->getBaseDir()));
        $this->parser->parse('install/index.tpl');
    }  
    
    public function database() {
        $this->parser->assign('flash_message', $this->session->flashdata('flash_message'));
        $this->parser->assign('current_step', 'database');
        $this->parser->assign('legend', 'Nastavenie pripojenia k databázovému serveru');
        $this->parser->parse('install/database.tpl');
    }
    
    public function make_database() {
        $this->load->library('form_validation');
        $fv = $this->form_validation;
        
        $fv->set_rules('db[hostname]', 'Hostiteľ', 'required');
        $fv->set_rules('db[username]', 'Meno používateľa', 'required');
        $fv->set_rules('db[password]', 'Heslo', 'required');
        $fv->set_rules('db[database]', 'Názov databázy', 'required');
        $fv->set_message('required', 'Položka %s je vyžadovaná.');
        
        if ($fv->run()) {
            $db = $this->getDatabaseConfig();
            $db = array_merge($db, $this->input->post('db'));
            $db_object = $this->load->database($db, TRUE, TRUE);
            if ($db_object->conn_id === FALSE) {
                $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Nepodarilo sa pripojiť k databáze MySQL. Skontrolujte údaje.'));
                redirect('install/database');
            } else {
                $db_all = array('default' => $db);
                if ($this->configurator->setConfigArrayCustom('database', $db_all, $this->getDatabaseConfigArangement(), '$db')) {
                    redirect('install/make_database_structure');                    
                } else {
                    $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Nepodarilo sa zapísať konfiguráciu databázy do konfiguračného súboru.'));
                    redirect('install/database');
                }
            }
        } else {
            $this->database();
        }
    }
    
    public function make_database_structure() {
        if ($this->_updateMigrations()) {
            $this->session->set_flashdata('flash_message', array('type' => 'success', 'message' => 'Databáza bola úspešne pripojená a databázová štruktúra vytvorená.'));
            redirect('install/adminacc');            
        } else {
            $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Nepodarilo sa vytvoriť databázovú štruktúru. Bola databáza prázdna?<br /><br />Popis chyby: ' . $this->migration->error_string()));
            redirect('install/database');
        }
    }
    
    public function adminacc() {
        $this->parser->assign('flash_message', $this->session->flashdata('flash_message'));
        $this->parser->assign('current_step', 'adminacc');
        $this->parser->assign('legend', 'Vytvorenie používateľského účtu administrátora');
        $this->parser->parse('install/adminacc.tpl');
    }
    
    public function make_adminacc() {
        $this->load->library('form_validation');
        $fv = $this->form_validation;
        
        $fv->set_rules('admin[email]', 'E-mail', 'required|valid_email|is_unique[admins.email]');
        $fv->set_rules('admin[email2]', 'E-mail (kontrola)', 'callback__is_same_as[admin[email]]');
        $fv->set_rules('admin[password]', 'Heslo', 'required|min_length[6]|max_length[20]');
        $fv->set_rules('admin[password2]', 'Heslo (kontrola)', 'callback__is_same_as[admin[password]]');
        $fv->set_message('required', 'Položka %s je vyžadovaná.');
        $fv->set_message('is_unique', 'Položka %s neobsahuje unikátnu hodnotu.');
        $fv->set_message('valid_email', 'Položka %s musí obsahovať platnú e-mailovú adresu.');
        $fv->set_message('_is_same_as', 'Položka %s sa musí zhodovať s položkou %s.');
        $fv->set_message('min_length', 'Položka %s musí obsahovať najmenej %s znakov.');
        $fv->set_message('max_length', 'Položka %s musí obsahovať najviac %s znakov.');
        
        if ($fv->run()) {
            $admin_data = $this->input->post('admin');
            $admin = $this->load->table_row('admins');
            $admin->setEmail($admin_data['email']);
            $admin->setPassword(md5($admin_data['password']));
            if (!$admin->save()) {
                $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Nepodarilo sa uložiť účet administrátora do databázy.'));
                redirect('install/adminacc');
            } else {
                $this->load->model('admins');
                if ($this->admins->loginAdmin($admin_data['email'], $admin_data['password'])) {
                    $this->session->set_flashdata('flash_message', array('type' => 'success', 'message' => 'Administrátorský účet bol vytvorený a automaticky prihlásený.'));
                    redirect('install/config');  
                } else {
                    $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Nepodarilo sa prihlásiť účet administrátora. Prihláste sa manuálne po dokončení inštalácie.'));
                    redirect('install/config');    
                }
            }
        } else {
            $this->adminacc();
        }
    }
    
    public function _is_same_as($string, $field) {
        $path = explode('[', str_replace(']', '', $field));
        $fld = $this->input->post($path[0]);
        if ($fld === FALSE) { return FALSE; }
        if (count($path) > 1) {
            for ($i=1;$i<count($path);$i++) {
                $segment = $path[$i];
                if (!isset($fld[$segment])) {
                    return FALSE;
                }
                $fld = $fld[$segment];
            }
        }
        if ($string == $fld) { return TRUE; }
        return FALSE;
    }
    
    public function config() {
        $this->parser->assign('flash_message', $this->session->flashdata('flash_message'));
        $this->parser->assign('current_step', 'config');
        $this->parser->assign('legend', 'Konfigurácia aplikácie');
        $this->parser->parse('install/config.tpl');
    }
    
    public function save_config() {
        $this->load->library('form_validation');
        $fv = $this->form_validation;
        
        $fv->set_rules('config[application][rewrite_enabled]', 'Zapnúť rewrite engine pre frontend', 'required|callback__valid_rewrite_enabled');
        $fv->set_rules('config[application][email][protocol]', 'E-mailový protokol', 'required|callback__valid_email_protocol');
        $fv->set_rules('config[application][email_from]', 'Adresa odchádzajúcej pošty', 'required|valid_email');
        $fv->set_rules('config[application][email_from_name]', 'Meno adresy odchádzajúcej pošty', 'required');
        $fv->set_rules('test_email', 'Adresa kam poslať testovací e-mail', 'required|valid_email');
        $fv->set_message('required', 'Položka %s je vyžadovaná.');
        $fv->set_message('valid_email', 'Položka %s musí byť platná e-mailová adresa.');
        $fv->set_message('alpha_numeric', 'Položka %s je môže obsahovať iba alfa-numerické znaky.');
        $fv->set_message('_valid_rewrite_enabled', 'Položka %s musí mať hodnotu 1 alebo 0.');
        $fv->set_message('_valid_email_protocol', 'Položka %s musí mať hodnotu smtp alebo mail.');
        
        if ($fv->run()) {
            $config = $this->input->post('config');
            $config['application']['rewrite_enabled'] = (bool)$config['application']['rewrite_enabled'];
            if ($this->configurator->setConfigArray('application', $config['application'])) {
                if ($this->sendTestEmail($this->input->post('test_email'))) {
                    $this->session->set_flashdata('flash_message', array('type' => 'success', 'message' => 'Konfigurácia bola uložená a testovací e-mail odoslaný.'));
                    redirect('install/finish');
                } else {
                    $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Nepodarilo sa odoslať testovací e-mail.'));
                    redirect('install/config');
                }
            } else {
                $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Konfiguráciu sa nepodarilo uložiť do konfiguračného súboru.'));
                redirect('install/config'); 
            }
        } else {
            $this->config();
        }
    }
    
    public function _valid_email_protocol($protocol) {
        if ($protocol == 'smtp' || $protocol == 'mail') {
            return TRUE;
        }
        return FALSE;
    }
    
    public function _valid_rewrite_enabled($value) {
        if ($value == 1 || $value == 0 || $value === TRUE || $value === FALSE) {
            return TRUE;
        }
        return FALSE;
    }
    
    private function sendTestEmail($email) {
        $this->load->library('email');
        $config = Abstract_common_controller::getConfigItem('application', 'email');
        $this->email->initialize($config);
        $from = Abstract_common_controller::getConfigItem('application', 'email_from');
        $from_name = Abstract_common_controller::getConfigItem('application', 'email_from_name');
        
        $this->email->from($from, $from_name);
        $this->email->to($email);
        $this->email->subject('Pokusný e-mail');
        
        $msg = '<div style="color: blue; background-color: white; padding: 4px; border: 1px solid black; border-radius: 4px">';
        $msg .= 'Toto je pokusná správa z konfigurátora nastavení.<br />Ak Vám prišla, znamená to, že máte v aplikácii nastavený e-mail správne.</div>';
        
        $this->email->message($msg);
        return $this->email->send();
    }
    
    public function finish() {
        $this->configurator->setConfigArray('application', array('installed' => true));
        $this->parser->assign('flash_message', $this->session->flashdata('flash_message'));
        $this->parser->assign('current_step', 'finish');
        $this->parser->assign('legend', 'H O T O V O');
        $this->parser->parse('install/finish.tpl');
    }
    
    public function _updateMigrations() {
        $this->load->database();
        
        return $this->_doUpdateMigrations($level);
    }
    
    public function _updateToMigration($level = NULL) {
        $this->load->database();
        
        return $this->_doUpdateMigrations($level);
    }

    public function _doUpdateMigrations($level = NULL) {
        if (is_null($level)) {
            return $this->migration->latest();
        }
        if (is_numeric($level)) {
            return $this->migration->version(intval($level));
        }
        return false;
    }
    
    private function getBaseDir() {
        $bd = str_replace(uri_string(), '', current_url());
        $bd = str_replace(index_page(), '', $bd);
        return rtrim($bd, '\\/') . '/';
    }
    
    private function getRandomEncryptionKey() {
        return strtoupper(md5(date('U') * rand(-5000000, 5000000) * __LINE__));
    }
    
    private function getDatabaseConfig() {
        include (APPPATH . 'config/database.php');
        return $db['default'];
    }
    
    private function getDatabaseConfigArangement() {
        $arangement = array(
            array('type' => 'comment', 'value' => '/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the \'Database Connection\'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	[\'hostname\'] The hostname of your database server.
|	[\'username\'] The username used to connect to the database
|	[\'password\'] The password used to connect to the database
|	[\'database\'] The name of the database you want to connect to
|	[\'dbdriver\'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	[\'dbprefix\'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	[\'pconnect\'] TRUE/FALSE - Whether to use a persistent connection
|	[\'db_debug\'] TRUE/FALSE - Whether database errors should be displayed.
|	[\'cache_on\'] TRUE/FALSE - Enables/disables query caching
|	[\'cachedir\'] The path to the folder where cache files should be stored
|	[\'char_set\'] The character set used in communicating with the database
|	[\'dbcollat\'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	[\'swap_pre\'] A default table prefix that should be swapped with the dbprefix
|	[\'autoinit\'] Whether or not to automatically initialize the database.
|	[\'stricton\'] TRUE/FALSE - forces \'Strict Mode\' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the \'default\' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/'),
            array('type' => 'custom', 'value' => '$active_group = \'default\';
$active_record = TRUE;'),
            array('type' => 'config', 'value' => array('default')),
            array('type' => 'comment', 'value' => '/* End of file database.php */
/* Location: ./application/config/database.php */'),
        );
        return $arangement;
    }
}

?>