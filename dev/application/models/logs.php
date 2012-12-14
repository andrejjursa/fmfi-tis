<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logs handler model.
 * 
 * @author Andrej Jursa
 * @version 1.0
 * @package AppModels
 */
class Logs extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Admins');
    }
    
    /**
     * Store log message and data to database.
     * 
     * @param string $message log message.
     * @param array<mixed> $data log data.
     */ 
    public function addLog($message = '', $data = array()) {
        $admin_id = intval($this->Admins->getAdminId());
        
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $this->db->set('tstamp', 'CURRENT_TIMESTAMP', FALSE);
        $this->db->set('crdate', 'CURRENT_TIMESTAMP', FALSE);
        $this->db->set('ipaddress', $ip);
        $this->db->set('admin_id', $admin_id);
        $this->db->set('message', $message);
        $this->db->set('data', base64_encode(serialize($data)));
        $this->db->insert('logs');
    }
    
}

?>