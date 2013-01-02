<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppControllers
 */
class DynamicLoad extends Abstract_common_controller {

    /**
     * Parse and return javascript file content.
     * 
     * @param string $file path and file name of javascript template file, withou .js extension.
     */
    public function loadJS($file = NULL) {
        $this->output->set_content_type('text/javascript');
        
        $data = $this->uri->uri_to_assoc(4);
        
        $this->parser->parse('javascript/' . $file . '.js', $data);
    }
    
}

?>