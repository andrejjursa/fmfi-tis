<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Common controller for frontend and backend.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

class Abstract_common_controller extends My_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('parser');
    }
    
}

?>