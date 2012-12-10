<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Administrator log in/out handling model.
 * 
 * @author Andrej Jursa, Michal Palenik
 * @version 1.0
 * @package AppModels
 */
class Admins extends CI_Model {
    
    /**
     * @var string key in session user data.
     */
    const USER_DATA_STRING = 'logged_in_admin'; 
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    
    /**
     * Performs admin login and set up session information.
     * Does nothing and return FALSE when administrator is already loged in.
     * 
     * @param string $email administrator e-mail.
     * @param string $password administrator password.
     * @return boolean TRUE, when login attempt were successful, FALSE otherwise or when administrator is already loged in.
     */
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
    
    /**
     * Verifies if administrator is loged in.
     * 
     * @return boolean returns TRUE if there is valid login, FALSE otherwise.
     */
    public function isAdminLogedIn() {
        $data = $this->session->userdata(Admins::USER_DATA_STRING);
        if (isset($data['id']) && !is_null($data['id']) && is_numeric($data['id']) && $data['id'] > 0) { return TRUE; }
        return FALSE;
    }
    
    /**
     * Returns administrator id or NULL if no administrator is loged in.
     * 
     * @return integer administrator id.
     */
    public function getAdminId() {
        if ($this->isAdminLogedIn()) {
            $data = $this->session->userdata(Admins::USER_DATA_STRING);
            return intval($data['id']);
        }
        return NULL;
    }
    
    /**
     * Returns administrator e-mail or NULL if no administrator is loged in.
     * 
     * @return string administrator e-mail.
     */
    public function getAdminEmail() {
        if ($this->isAdminLogedIn()) {
            $data = $this->session->userdata(Admins::USER_DATA_STRING);
            return $data['email'];
        }
        return NULL;
    }
    
    /**
     * Log out administrator.
     * 
     * @return boolean TRUE on success, FALSE when no administrator is loged in.
     */
    public function logoutAdmin() {
        if ($this->isAdminLogedIn()) {
            $this->session->unset_userdata(Admins::USER_DATA_STRING);
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Verifies if entered email exists in table admins.
     *
     */              
    
    public function adminExists($email){
          $admin = $this->load->table_row('admins');
          $admin->loadByLogin($email);
          if(is_null($admin->getId())){
            return FALSE;
          }
          else{
            return TRUE;
          }
    }
    
    /**
     * Updates Validation Token for admin with $id. 
     *
     */              
    
    public function updateValidToken($id,$token){
        $admin = $this->load->table_row('admins');
        $admin->load($id);
        $admin->data(array( 'validation_token' => $token ));
        $admin->save();          
    }
    
    
    /**
     * Upadtes password of admin with $id.
     *
     */              
    
    public function updatePassword($id,$pass){
        $admin = $this->load->table_row('admins');
        $admin->load($id);
        $admin->data(array( 'password' => md5($pass) ));
        $admin->save(); 
    }
    
    /**
     * Upadtes new_email of admin with $id.
     *
     */              
    
    public function updateEmail($id,$email){
        $admin = $this->load->table_row('admins');
        $admin->load($id);
        $admin->data(array( 'new_email' => $email ));
        $admin->save(); 
    }
    
    public function getIdByEmail($email){
        $admin = $this->load->table_row('admins');
        $admin->loadByLogin($email);
        return $admin->GetId();    
    }
    
    
    
}

?>