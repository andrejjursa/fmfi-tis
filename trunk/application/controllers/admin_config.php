<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class Admin_config extends Abstract_backend_controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function index() {
        $this->load->model('configurator');
        $config['application'] = $this->configurator->getConfigArray('application');
        $config['application']['rewrite_enabled'] = intval($config['application']['rewrite_enabled']);
        $config['config'] = $this->configurator->getConfigArray('config');
        $config['smarty'] = $this->configurator->getConfigArray('smarty');
        $config['smarty']['compile_check'] = intval($config['smarty']['compile_check']);
        $this->parser->assign('config', $config);
        
        $this->_addTemplateJs('admin_config/index.js');
        $this->_assignTemplateAdditionals();
        
        $this->parser->assign('flash_message', $this->session->flashdata('flash_message'));
        
        $this->parser->parse('backend/admin_config.index.tpl');
    }
    
    public function save() {
        $this->load->library('form_validation');
        $fv = $this->form_validation;
        
        $fv->set_rules('config[application][rewrite_enabled]', 'Rewrite engine', 'required|callback__valid_boolean_value');
        $fv->set_rules('config[smarty][compile_check]', 'Rewrite engine', 'required|callback__valid_boolean_value');
        $fv->set_rules('config[config][encryption_key]', 'Bezpečnostný kryptovací kľúč', 'required|alpha_numeric|exact_length[32]');
        $fv->set_rules('config[application][email][protocol]', 'E-mailový protokol', 'required|callback__valid_email_protocol');
        $fv->set_rules('config[application][email_from]', 'E-mail odchádzajúcej pošty', 'required|valid_email');
        $fv->set_rules('config[application][email_from_name]', 'Meno e-mailu odchádzajúcej pošty', 'required');
        $fv->set_message('required', 'Položka %s je vyžadovaná.');
        $fv->set_message('valid_email', 'Položka %s musí byť platná e-mailová adresa.');
        $fv->set_message('alpha_numeric', 'Položka %s je môže obsahovať iba alfa-numerické znaky.');
        $fv->set_message('exact_length', 'Položka %s musí mať presne %s znakov.');
        $fv->set_message('_valid_boolean_value', 'Položka %s musí mať hodnotu 1 alebo 0.');
        $fv->set_message('_valid_email_protocol', 'Položka %s musí mať hodnotu smtp alebo mail.');
        
        if ($fv->run()) {
            $this->load->model('configurator');
            $config = $this->input->post('config');
            $config['application']['rewrite_enabled'] = (bool)$config['application']['rewrite_enabled'];
            $config['smarty']['compile_check'] = (bool)$config['smarty']['compile_check'];
            if ($this->configurator->setConfigArray('config', $config['config']) && 
                $this->configurator->setConfigArray('application', $config['application']) &&
                $this->configurator->setConfigArray('smarty', $config['smarty'])) {
                $this->session->set_flashdata('flash_message', array('type' => 'success', 'message' => 'Dáta boli úspešne úložené.'));
            } else {
                $this->session->set_flashdata('flash_message', array('type' => 'error', 'message' => 'Niektoré dáta sa nepodarilo uložiť.'));
            }
            $this->load->helper('url');
            redirect(createUri('admin_config', 'index'));
        } else {
            $this->index();
        }
    }
    
    public function _valid_email_protocol($protocol) {
        if ($protocol == 'smtp' || $protocol == 'mail') {
            return TRUE;
        }
        return FALSE;
    }
    
    public function _valid_boolean_value($value) {
        if ($value == 1 || $value == 0 || $value === TRUE || $value === FALSE) {
            return TRUE;
        }
        return FALSE;
    }
    
    public function generateEncryptionKey() {
        $this->load->model('admins');
        $key = strtoupper(md5(date('U') * rand(1, 2000000) * $this->admins->getAdminId()));
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode($key));
    }
    
    public function testEmailSending() {
        $this->load->library('form_validation');
        $fv = $this->form_validation;
        
        $fv->set_rules('email', 'E-mail', 'required|valid_email');
        $fv->set_message('required', 'E-mail nebol zadaný!');
        $fv->set_message('valid_email', 'Zadaný e-mail nie je platnou adresou!');
        $fv->set_error_delimiters('', '');
        
        $message = '';
        $type = 'failed';
        
        if ($fv->run()) {
            $this->load->library('email');
            $config = self::getConfigItem('application', 'email');
            $this->email->initialize($config);
            $from = self::getConfigItem('application', 'email_from');
            $from_name = self::getConfigItem('application', 'email_from_name');
            
            $this->email->from($from, $from_name);
            $this->email->to($this->input->post('email'));
            $this->email->subject('Pokusný e-mail');
            
            $msg = '<div style="color: blue; background-color: white; padding: 4px; border: 1px solid black; border-radius: 4px">';
            $msg .= 'Toto je pokusná správa z konfigurátora nastavení.<br />Ak Vám prišla, znamená to, že máte v aplikácii nastavený e-mail správne.</div>';
            
            $this->email->message($msg);
            if ($this->email->send()) {
                $message = 'Správa bola úspešne odoslaná. Skontrolujte či prišla na Vami zadanú e-mailovú adresu.';
                $type = 'success';
            } else {
                $message = 'Správa nebola odoslaná.';
            }
        } else {
            $message = validation_errors();
        }
        
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode(array('type' => $type, 'message' => $message)));
    }
    
    public function clearCompiledTemplates() {
        $this->parser->clearCompiledTemplate();
    }
    
}

?>