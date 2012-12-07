<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
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
    
    public function updateToMigration($level = NULL) {
        $this->load->database();
        
        if (!$this->_doUpdateMigrations($level)) {
            show_error($this->migration->error_string());
        }
    }

    public function _doUpdateMigrations($level = NULL) {
        if (is_null($level)) {
            return $this->migration->latest();
        }
        if (is_numeric($level)) {
            return $this->migration->version(intval($level));
        }
        return false;
    }
}

?>