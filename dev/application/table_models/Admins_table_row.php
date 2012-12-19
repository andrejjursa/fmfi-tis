<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package TableModels
 */
class Admins_table_row extends Abstract_table_row {
    
    /**
     * Loads row corresponding to given login data.
     * 
     * @param string $email administrator e-mail address.
     * @param string $password administrator password.
     * @return boolean.
     */
    public function loadByLoginData($email, $password) {
        return $this->loadBy('email = ? AND password = ?', $email, md5($password));
    }
    
    /**
     * Loads row with matched email.
     *
     */                                           
    public function loadByLogin($email){
        return $this->loadBy('email = ? ', $email);
    }
    
    /**
     * Loads row with matched validation_token.
     *
     */                                           
    public function loadByToken($token){
        return $this->loadBy('validation_token = ? ', $token);
    }
    
}

?>