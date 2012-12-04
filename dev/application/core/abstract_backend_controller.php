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
        $this->load->library('session');
        $logged = $this->session->userdata('logged');
        $this->load->helper('url');

        if($logged){
          
        }
        else{
          if(!($this->input->post('reset')) &&  !($this->input->post('log'))){        
            $redirect = array(
                      'redirect' => ''
                     );
            if($this->session->userdata('redirect')){
              $redirect['redirect'] = 0;
              $this->session->set_userdata($redirect);
            }
            else{
              $redirect['redirect'] = 1;
              $this->session->set_userdata($redirect);            
              redirect('/Admin/login');
            }                   
          }
        }                     
        $this->_adminMenu();  
    }
    
    private function _adminMenu() {
        $this->load->library('parser');
        
        $menu = $this->getConfigItem('adminmenu', 'menu');
        if($this->session->userdata('logged')){
          array_push($menu, array(
                'title' => 'Logout',
                'link' => array(
                    'controller' => 'Admin',
                    'action' => 'logout',
                    'params' => '',
                ),
                'sub' => NULL,
            ));
        }
        
        $this->parser->assign('adminmenu', $menu);
        
        $this->_addTemplateCss('jMenu.jquery.css');
        $this->_addTemplateJs('jMenu.jquery.min.js');
        $this->_addTemplateJs('adminmenu.js');
        $this->_assignTemplateAdditionals();
    }
}

?>