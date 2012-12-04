<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'core/abstract_common_controller.php';

class Admin extends Abstract_backend_controller {

//        $this->parser->assign('error','');

  
  public function index(){
      $this->dashboard();
  }
  
  public function login(){ 

      $this->parser->parse("backend/admin.Login.tpl");
      
  }
  
  public function dashboard(){
    $this->parser->parse('backend/admin.Dashboard.tpl');
  }
  
  public function do_login(){
      $this->load->database();  
      $this->load->helper('form');
      $this->load->library('form_validation');
      $this->form_validation->set_rules('meno','Email','required|valid_email');
      $this->form_validation->set_rules('pass','Heslo','required');
      if($this->form_validation->run() == FALSE){
        $this->parser->parse("backend/admin.Login.tpl");
      }      
      else{
        $query = $this->db->query("SELECT * FROM admins WHERE email='".$this->input->post('meno')."' AND password=MD5('".$this->input->post('pass')."')");
        if($query->num_rows() > 0){
          $this->session->set_userdata(array(
                                      'logged' => $this->input->post('meno') ));
          $this->dashboard();
        }
        else{
          $this->parser->assign('error','Zadali ste zly email alebo heslo.');
          $this->parser->parse("backend/admin.Login.tpl");
        }
      }
  }
  
  public function logout(){
    $this->session->unset_userdata('logged');
    redirect('/Admin/login');  
  }
  
  public function forgotten_password(){
  
  }

}

?>
