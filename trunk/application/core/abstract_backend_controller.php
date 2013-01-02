<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'core/abstract_common_controller.php';

/**
 * Base controller class for all backend controllers.
 *
 * @author Michal Palenik, Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */
class Abstract_backend_controller extends Abstract_common_controller {
    
    /**
     * @var array<string> names of actions, which are not be checked for valid admin login.
     */
    private $login_dontvalidate = array();
    
    /**
     * Main constructor, executes login  check.
     */
    public function __construct() {
        parent::__construct();
        forceDisableRewriteEngine();
        $this->load->model('Admins');
        $this->parser->assign('Admins_model', $this->Admins);
        $this->_validateLogin();
        $this->_adminMenu();  
    }
    
    /**
     * Fetch admin menu from config file and assign them to template.
     */
    private function _adminMenu() {
        $this->load->library('parser');
        
        $menu = $this->getConfigItem('adminmenu', 'menu');
        $this->parser->assign('adminmenu', $menu);
        
        $this->_addTemplateCss('jMenu.jquery.css');
        $this->_addTemplateJs('jMenu.jquery.min.js');
        $this->_addTemplateJs('adminmenu.js');
        $this->_assignTemplateAdditionals();
    }
    
    /**
     * Add controller action to the list of actions, which are not checked for valid login.
     * 
     * @param string $action name of action.
     */
    protected function _doNotValidateLoginAtAction($action) {
        if (method_exists($this, $action) && !in_array($action, $this->login_dontvalidate)) {
            $this->login_dontvalidate[] = $action;
        }
    }
    
    /**
     * Verify if current action can be checked for valid login.
     * 
     * @return boolean if it's TRUE, login check can be verified.
     */
    private function _validateLoginCheck() {
        $action = $this->router->fetch_method();
        
        if (in_array($action, $this->login_dontvalidate)) { return FALSE; }
        return TRUE;
    }
    
    /**
     * Validates login, if is not valid, redirects request to the login form.
     */
    private function _validateLogin() {
        if (!$this->Admins->isAdminLogedIn()) {
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