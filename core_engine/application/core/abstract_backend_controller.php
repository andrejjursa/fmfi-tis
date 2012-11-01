<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Base controller class for all backend controllers.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

require_once APPPATH . 'core/abstract_common_controller.php';

class Abstract_backend_controller extends Abstract_common_controller {
    
    public function __construct() {
        parent::__construct();
    }
       
}

?>