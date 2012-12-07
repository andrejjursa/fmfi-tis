<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package TableModels
 */
class Logs_table_row extends Abstract_table_row {
    
    protected $admin = NULL;
    
    public function init() {
        $this->admin = $this->load->table_relation('logs', 'one_admin');
    }
    
    public function resetRelations() {
        $this->admin->reset();
    }
    
    public function getLogData() {
        return unserialize(base64_decode($this->getData()));
    }
    
    public function getAdminEmail() {
        $email = NULL;
        
        $admin = $this->admin->get($this->getId(), $this->getAdmin_id());
        
        if (is_array($admin) && count($admin) == 1) {
            $email = $admin[0]->getEmail();
        }
        
        return $email;
    }
    
}

?>