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
    
    private $login_dontvalidate = array();
    
    public function __construct() {
        parent::__construct();
        $this->_validateLogin();
        $this->_adminMenu();  
    }
    
    private function _adminMenu() {
        $this->load->library('parser');
        
        $menu = $this->getConfigItem('adminmenu', 'menu');
        $this->parser->assign('adminmenu', $menu);
        
        $this->_addTemplateCss('jMenu.jquery.css');
        $this->_addTemplateJs('jMenu.jquery.min.js');
        $this->_addTemplateJs('adminmenu.js');
        $this->_assignTemplateAdditionals();
    }
    
    protected function _doNotValidateLoginAtAction($action) {
        if (method_exists($this, $action) && !in_array($action, $this->login_dontvalidate)) {
            $this->login_dontvalidate[] = $action;
        }
    }
    
    private function _validateLoginCheck() {
        $action = $this->router->fetch_method();
        
        if (in_array($action, $this->login_dontvalidate)) { return FALSE; }
        return TRUE;
    }
    
    private function _validateLogin() {
        $this->load->library('session');
        $loged_in_user = $this->session->userdata('logged_in_user');
        
        if (!isset($loged_in_user['id']) || $loged_in_user['id'] === NULL) {
            if ($this->_validateLoginCheck()) {
                $controller = self::getConfigItem('application', 'admin_login_controller');
                $action = self::getConfigItem('application', 'admin_login_action');
                $this->load->helper('application');
                $this->load->helper('url');
                redirect(createUri($controller, $action));
            }
        } 
    }
}

?>