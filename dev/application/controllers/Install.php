<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Install extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->library('migration');
    }

    public function index() {
        echo 'Hallo world!';
    }  
    
    public function updateMigrations() {
        $this->load->database();
        
        if (!$this->_doUpdateMigrations()) {
            show_error($this->migration->error_string());
        }
    }

    public function _doUpdateMigrations() {
        return $this->migration->latest();
    }
}

?>