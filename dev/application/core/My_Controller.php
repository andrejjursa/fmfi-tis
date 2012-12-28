<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Custom controller extension, it loads additional controller classes.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */

require_once APPPATH . 'core/abstract_frontend_controller.php';
require_once APPPATH . 'core/abstract_backend_controller.php';

class My_Controller extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('parser');
        $this->load->helper('application');
        
        $this->parser->registerPlugin('function', 'createUri', 'smartyCreateUri');
        $this->parser->registerPlugin('function', 'imageThumb', 'smartyImageThumb');
        $this->parser->registerPlugin('function', 'form_error', 'smartyFormError');
    }
    
}

?>