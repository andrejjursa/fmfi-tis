<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admins extends CI_Model {
    
    const USER_DATA_STRING = 'logged_in_admin'; 
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    
    public function loginAdmin($email, $password) {
        if ($this->isAdminLogedIn()) { return FALSE; }
        $admin = $this->load->table_row('admins');
        $admin->loadByLoginData($email, $password);
        
        if (is_null($admin->getId())) {
            return FALSE;
        }
        
        $this->session->set_userdata(Admins::USER_DATA_STRING, array(
            'id' => $admin->getId(),
            'email' => $admin->getEmail(),
        ));
        
        return TRUE;
    }
    
    public function isAdminLogedIn() {
        $data = $this->session->userdata(Admins::USER_DATA_STRING);
        if (isset($data['id']) && !is_null($data['id']) && is_numeric($data['id']) && $data['id'] > 0) { return TRUE; }
        return FALSE;
    }
    
    public function getAdminId() {
        if ($this->isAdminLogedIn()) {
            $data = $this->session->userdata(Admins::USER_DATA_STRING);
            return $data['id'];
        }
        return NULL;
    }
    
    public function getAdminEmail() {
        if ($this->isAdminLogedIn()) {
            $data = $this->session->userdata(Admins::USER_DATA_STRING);
            return $data['email'];
        }
        return NULL;
    }
    
    public function logoutAdmin() {
        if ($this->isAdminLogedIn()) {
            $this->session->unset_userdata(Admins::USER_DATA_STRING);
        }
        return FALSE;
    }
    
}

?>