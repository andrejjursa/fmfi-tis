<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Base controller class for all frontend controllers.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */

require_once APPPATH . 'core/abstract_common_controller.php';

class Abstract_frontend_controller extends Abstract_common_controller {
    
    public function __construct() {
        parent::__construct();
    }
       
}

?>