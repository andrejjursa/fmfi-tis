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
     * Performs update of session data, only if there is valid administrator login.
     */
    public function updateSessionData() {
        if ($this->isAdminLogedIn()) {
            $id = $this->getAdminId();
            $admin = $this->load->table_row('admins');
            $admin->load($id);
            $this->session->set_userdata(Admins::USER_DATA_STRING, array(
                'id' => $admin->getId(),
                'email' => $admin->getEmail(),
            ));
        }
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
        if(is_null($admin->getId())) {
            return FALSE;
        } else{
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
        return $admin->save(); 
    }
    
    /**
     * Upadtes 'new_email' and 'validation_token' of admin with $id.
     * 
     * @param int $id Id of admin
     * @param string $email new email
     * @param string $validation_token token for validation
     * 
     * @return bolean True if email is updated or False when fails.
     */              
    public function updateNewEmail($id,$email, $validation_token){
        $admin = $this->load->table_row('admins');
        $admin->load($id);
        $admin->data(array( 'new_email' => $email, 'validation_token' => $validation_token ));
        return $admin->save(); 
    }
    
    
    
    /**
     * Set value 'email' to 'new_email' and 'new_email' and 'validation_token' to ""
     * 
     * @param int $id Id of admin
     * @param string $email new email
     * 
     * @return bolean True if email is updated or False when fails.
     */                  
    public function updateEmail($id, $email = NULL){
        $admin = $this->load->table_row('admins');
        $admin->load($id);
        $new_email = (!is_null($email))?$email:$admin->getNew_email();
        $other_admin = $this->load->table_row('admins');
        $other_admin->loadBy('email = ?', $new_email);
        if (is_null($other_admin->getId())) {
            $admin->data(array( 
                'email' => $new_email, 
                "new_email" => "", 
                "validation_token" => ""
            ));
            return $admin->save(); 
        } else {
            return FALSE;
        }
    }
    
    public function getIdByEmail($email){
        $admin = $this->load->table_row('admins');
        $admin->loadByLogin($email);
        return $admin->GetId();    
    }
    
    public function getIdByValidToken($token){
        $admin = $this->load->table_row('admins');
        $admin->loadByToken($token);
        return $admin->GetId();    
    }
    
    
}

?>