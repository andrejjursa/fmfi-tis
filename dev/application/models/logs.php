<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logs extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Admins');
    }
    
    public function addLog($message = '', $data = array()) {
        $admin_id = intval($this->Admins->getAdminId());
        
        $this->db->set('tstamp', 'CURRENT_TIMESTAMP', FALSE);
        $this->db->set('crdate', 'CURRENT_TIMESTAMP', FALSE);
        $this->db->set('admin_id', $admin_id);
        $this->db->set('message', $message);
        $this->db->set('data', base64_encode(serialize($data)));
        $this->db->insert('logs');
    }
    
}

?>