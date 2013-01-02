<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Common controller for frontend and backend.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */
class Abstract_common_controller extends MY_Controller {
    
    /**
     * @var array<stdClass> array of additional js files. 
     */
    private $template_js_files = array();
    /**
     * @var array<stdClass> array of additional css files. 
     */
    private $template_css_files = array();
    
    /**
     * Main constructor of common controller with initialisations.
     */
    public function __construct() {
        parent::__construct();
        
        if (!self::getConfigItem('application', 'installed')) {
            $this->load->helper('url');
            redirect('install');
        }
        
        $this->_resetTemplateCss();
        $this->_resetTemplateJs();
        $this->_assignTemplateAdditionals();
        
        $this->parser->assign('site_base_url', self::getBaseUrl());
    }
    
    /**
     * Add additional css file to list of additional css files.
     * 
     * @param type $filename path and name of css file.
     * @param type $media media parameter value of link tag.
     */
    public function _addTemplateCss($filename, $media = 'screen') {
        $css = new stdClass();
        $css->media = $media;
        
        $base_url = self::getBaseUrl();
        
        $css->href = $base_url . 'public/css/' . $filename;
        
        $this->template_css_files[] = $css;
    }
    
    /**
     * Resets additional css files list to empty.
     */
    public function _resetTemplateCss() {
        $this->template_css_files = array();
    }
    
    /**
     * Add additional js file to list of additional js files.
     * 
     * @param type $filename path and name of css file.
     */
    public function _addTemplateJs($filename) {
        $js = new stdClass();
        
        $base_url = self::getBaseUrl();
        
        $js->src = $base_url . 'public/js/' . $filename;
        
        $this->template_js_files[] = $js;
    }
    
    /**
     * Add additional js file to list of additional js files.
     * This is special call of js file through smarty parser.
     * 
     * @param type $filename path and file name, without extension.
     * @param type $params smarty template vars definition array, it will be part of url!.
     */
    public function _addTemplateDynamicJs($filename, $params = array()) {
        $js = new stdClass();
        
        $realParams = array_merge(array($filename), $params);
        
        $src = createUri('dynamicLoad', 'loadJS', $realParams);
        
        $js->src = $src;
        
        $this->template_js_files[] = $js;
    }
    
    /**
     * Resets additional js files list to empty.
     */
    public function _resetTemplateJs() {
        $this->template_js_files = array();
    }
    
    /**
     * Assigns both css and js lists to smarty template.
     */
    public function _assignTemplateAdditionals() {
        $this->parser->assign('additional_css_files', $this->template_css_files);
        $this->parser->assign('additional_js_files', $this->template_js_files);
    }
    
    /**
     * Returns base url from config file.
     * 
     * @return string base url.
     */
    public static function getBaseUrl() {
        $base_url = self::getConfigItem('config', 'base_url');
        $base_url = $base_url[strlen($base_url) - 1] == '/' ? $base_url : $base_url . '/';
        
        return $base_url;
    }
    
    /**
     * Returns config item value from given file.
     * 
     * @param string $config_file configuration file name without extension.
     * @param string $item name of item to fetch from config file.
     * @return mixed value of config file item.
     */
    public static function getConfigItem($config_file, $item) {
        $CI =& get_instance();
        $CI->config->load($config_file, TRUE);
        return $CI->config->item($item, $config_file);
    }
}

?>