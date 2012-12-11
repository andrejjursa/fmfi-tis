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
		$this->load->model('Logs');
		
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Heslo','required|min_length[6]|max_length[20]');
        $this->form_validation->set_message('required', '<strong>%s</strong> musí byť vyplnené.');
        $this->form_validation->set_message('valid_email', '<strong>%s</strong> musí byť e-mailová adresa.');
        $this->form_validation->set_message('min_length', '<strong>%s</strong> musí byť dlhé najmenej <strong>%s</strong> znakov.');
        $this->form_validation->set_message('max_length', '<strong>%s</strong> môže byť dlhé najviac <strong>%s</strong> znakov.');
        if ($this->form_validation->run()) {
            if ($this->Admins->loginAdmin($this->input->post('email'), $this->input->post('password'))) {
				$this->Logs->addLog('Administrator login successful', array('type' => 'login', 'result' => 'OK', 'email' => $this->input->post('email')));
                redirect(createUri('admin', 'dashboard'));
            } else {
				$this->Logs->addLog('Administrator login failed', array('type' => 'login', 'result' => 'FAILED', 'email' => $this->input->post('email')));
                $this->parser->assign('login_error', TRUE);
                $this->parser->parse('backend/admin.login.tpl');
            }
        } else {
            $this->parser->parse('backend/admin.login.tpl');
        }
    }
  
    public function logout() {
		$this->load->model('Logs');
		$this->Logs->addLog('Administrator logout', array('type' => 'logout'));
        $this->Admins->logoutAdmin();		
        redirect(createUri('admin', 'login'));  
    }
    
    public function forgotten_password(){
        $this->parser->parse('backend/admin.forgottenPassword.tpl');
    }
    
    public function send_password_request(){
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_message('required', '<strong>%s</strong> musí byť vyplnené.');
        $this->form_validation->set_message('valid_email', '<strong>%s</strong> musí byť e-mailová adresa.');
        if($this->form_validation->run()){
            if($this->admins->adminExists($this->input->post('email'))){
                  $this->load->library('email');
                  
                  $this->email->from('Sidirius.Andyron@gmail.com','MP');
                  $this->email->to($this->input->post('email'));
                  $this->email->subject('Obnova hesla');
                  $token = generateToken();
                  $id = $this->admins->getIdByLogin($this->input->post('email'));
                  $message = "Bola zaznamenaná žiadosť o obnovenie vášho hesla. Ak ste neboli autorom tejto žiadosti môžete mail ignorovať./n
                              Pre obnovenie vášho hesla pokračujte kliknutím na linku nižšie. Tá vás presmeruje na formulár kde zadáte nové heslo./n"
                              + CreateUri('admin','renew_password',$token);
                  $this->admins->updateValidToken($id,$token);                              
                              
                  $this->email->message($message);
                  $this->email-send();
            }
        }
        else{
            $this->parser->parse('backend/admin.forgottenPassword.tpl');
        }            
    }

}

?>
