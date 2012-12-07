<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH . 'core/abstract_common_controller.php';

/**
 * @package AppControllers
 */
class Admin extends Abstract_backend_controller {
    
    public function __construct() {
        $this->_doNotValidateLoginAtAction('login');
        $this->_doNotValidateLoginAtAction('do_login');
        $this->_doNotValidateLoginAtAction('forgotten_password');
        parent::__construct();
        $this->parser->disable_caching();
        $this->load->helper(array('url', 'application'));
    }
    
    public function index() {
        redirect(createUri('admin', 'dashboard'));
    }
  
    public function login() { 
        if ($this->Admins->isAdminLogedIn()) {
            redirect(createUri('admin', 'dashboard'));
        }
        $this->parser->parse("backend/admin.login.tpl");
    }
  
    public function dashboard() {
        $this->parser->parse('backend/admin.dashboard.tpl');
    }
  
    public function do_login() {
        if ($this->Admins->isAdminLogedIn()) {
            redirect(createUri('admin', 'dashboard'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Heslo','required|min_length[6]|max_length[20]');
        $this->form_validation->set_message('required', '<strong>%s</strong> musí byť vyplnené.');
        $this->form_validation->set_message('valid_email', '<strong>%s</strong> musí byť e-mailová adresa.');
        $this->form_validation->set_message('min_length', '<strong>%s</strong> musí byť dlhé najmenej <strong>%s</strong> znakov.');
        $this->form_validation->set_message('max_length', '<strong>%s</strong> môže byť dlhé najviac <strong>%s</strong> znakov.');
        if ($this->form_validation->run()) {
            if ($this->Admins->loginAdmin($this->input->post('email'), $this->input->post('password'))) {
                redirect(createUri('admin', 'dashboard'));
            } else {
                $this->parser->assign('login_error', TRUE);
                $this->parser->parse('backend/admin.login.tpl');
            }
        } else {
            $this->parser->parse('backend/admin.login.tpl');
        }
    }
  
    public function logout() {
        $this->Admins->logoutAdmin();
        redirect(createUri('admin', 'login'));  
    }
    
    public function forgotten_password(){
    
    }

}

?>
