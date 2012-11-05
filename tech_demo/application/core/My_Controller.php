<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom controller extension, it loads additional controller classes.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

require_once APPPATH . 'core/abstract_frontend_controller.php';
require_once APPPATH . 'core/abstract_backend_controller.php';

class My_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
}

?>