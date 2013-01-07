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
        $this->_doNotValidateLoginAtAction('send_password_request');
        $this->_doNotValidateLoginAtAction('renew_password');
        $this->_doNotValidateLoginAtAction('do_renew_password');
        
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
        $physicists = $this->load->table_collection('physicists');
        $this->parser->assign('physicists_count', $physicists->count());
        $inventions = $this->load->table_collection('inventions');
        $this->parser->assign('inventions_count', $inventions->count());
        $periods = $this->load->table_collection('periods');
        $this->parser->assign('periods_count', $periods->count());
        $miniapps = $this->load->table_collection('miniapps');
        $this->parser->assign('miniapps_count', $miniapps->count());
        $images = $this->load->table_collection('images');
        $this->parser->assign('images_count', $images->count());
        
        $this->_addTemplateJs('admin_editor/index.js');
        $this->_addTemplateJs('admin/dashboard.js');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin.dashboard.tpl');
    }
  
    public function do_login() {
        if ($this->Admins->isAdminLogedIn()) {
            redirect(createUri('admin', 'dashboard'));
        }
		$this->load->model('Logs');
		
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','E-mail','required|valid_email');
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
    
    public function forgotten_password() {
        $this->parser->parse('backend/admin.forgottenPassword.tpl');
    }
    
    public function send_password_request() {    
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','E-mail','required|valid_email');
        $this->form_validation->set_message('required', '<strong>%s</strong> musí byť vyplnené.');
        $this->form_validation->set_message('valid_email', '<strong>%s</strong> musí byť e-mailová adresa.');
        if($this->form_validation->run()) {
            if($this->Admins->adminExists($this->input->post('email'))) {
			
                  $config = self::getConfigItem('application', 'email');

                  $this->load->library('email',$config);
                  $this->load->helper('url');
                  $this->email->initialize($config);
                  
                  $from = self::getConfigItem('application', 'email_from');
                  $from_name = self::getConfigItem('application', 'email_from_name');

                  $this->email->from($from, $from_name);
                  $this->email->to($this->input->post('email'));
                  $this->email->subject('Obnova hesla');
                  $token = generateToken();
                  $id = $this->Admins->getIdByEmail($this->input->post('email'));  
				  
                  $url = createUri('admin', 'renew_password', array($token));
				  
                  $sprava = "Bola zaznamenaná žiadosť o obnovenie Vášho hesla. Ak ste neboli autorom tejto žiadosti môžete e-mail ignorovať.\n";
                  $sprava .= "Pre obnovenie Vášho hesla pokračujte kliknutím na linku nižšie. Tá Vás presmeruje na formulár kde zadáte nové heslo.\n";
                  $sprava .= "<a href='$url'>$url</a>\n";
				  
                  $this->Admins->updateValidToken($id,$token);                              
                              
                  $this->email->message($sprava);
                  $this->email->send();
                  $this->parser->parse('backend/admin.succes_sent_mail.tpl');
            } else {
                $this->parser->assign('login_error', TRUE);
                $this->parser->parse('backend/admin.forgottenPassword.tpl');
            }
        }
        else{
            $this->parser->parse('backend/admin.forgottenPassword.tpl');
        }            
    }
    
    public function renew_password($token = 0){
        if($token){
          $id = $this->Admins->getIdByValidToken($token);
          if($id){
            $this->parser->assign('id',$id);
            $this->parser->assign('token',$token);
            $this->parser->parse('backend/admin.renewPassword.tpl');          
          }
          else{
              $this->parser->parse('backend/admin.token_outofdate.tpl');
          }
        }
    }
    
    public function do_renew_password(){
        if(($this->input->post('id') == 0)||($this->input->post('id') != $this->Admins->getIdByValidToken($this->input->post('token')))){
            redirect(createUri('admin', 'login'));
        }
        $this->parser->assign('id',$this->input->post('id'));
        $this->parser->assign('token',$this->input->post('token'));
       
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pass','Heslo','required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('npass','Potvrdenie','required|matches[pass]');
        $this->form_validation->set_message('matches', '<strong>%s</strong> sa musí zhodovat s <strong>%s</strong>.');
        $this->form_validation->set_message('required', '<strong>%s</strong> musí byť vyplnené.');
        $this->form_validation->set_message('min_length', '<strong>%s</strong> musí byť dlhé najmenej <strong>%s</strong> znakov.');
        $this->form_validation->set_message('max_length', '<strong>%s</strong> môže byť dlhé najviac <strong>%s</strong> znakov.');
        if ($this->form_validation->run()) {
            if ($this->input->post('pass') == $this->input->post('npass')){
              $this->Admins->updatePassword($this->input->post('id'),$this->input->post('pass'));
              $this->Admins->updateValidToken($this->input->post('id'),'');
              $this->parser->parse('backend/admin.passchangesucces.tpl');
            } else {
		      $this->parser->assign('pass_error', TRUE);
              $this->parser->parse('backend/admin.renewPassword.tpl');
            }
        } else {
            $this->parser->parse('backend/admin.renewPassword.tpl');
        }

    }
    
    public function check_email() {
        $row_id = $this->input->post('row_id');
        $data = $this->input->post('data');
        $admins = $this->load->table_row('admins');
        $admins->loadBy('email = ?', $data['email']);
        if (is_null($admins->getId())) {
            echo json_encode(TRUE);
        } else {
            if ($admins->getId() == $row_id) {
                echo json_encode(TRUE);
            } else {
                echo json_encode(FALSE);
            }
        }
    }

}

?>
