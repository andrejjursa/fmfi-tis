<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * Returns url for navigation between controllers and actions.
 * 
 * @param string $controller name of controller.
 * @param string $action name of action.
 * @param array<mixed> $params array of parameters.
 * @return string full internet address.
 */
function createUri($controller, $action = 'index', $params = array()) {
    $CI =& get_instance();
    
    $base_url = Abstract_common_controller::getBaseUrl();
    
    $CI->config->load('application', TRUE);
    $rewrite_enabled = $CI->config->item('rewrite_enabled', 'application');
    
    $url = $base_url . ($rewrite_enabled ? '' : 'index.php/') . rawurlencode($controller) . '/' . rawurlencode($action) . '/';
    
    if (count($params)) {
        $keyValueParams = array();
        $simpleParams = array();
        foreach ($params as $key => $value) {
            if (is_numeric($key)) {
                $simpleParams[] = rawurlencode($value);
            } else {
                $keyValueParams[$key] = rawurlencode($value);
            }
        }
        $simpleParamsUri = implode('/', $simpleParams);
        $keyValueParamsUri = $CI->uri->assoc_to_uri($keyValueParams);
        if (!empty($simpleParamsUri)) {
            $url .= $simpleParamsUri . '/';
        }
        if (!empty($keyValueParamsUri)) {
            $url .= $keyValueParamsUri . '/';
        }
    }
    
    return $url;
}

/**
 * Masks createUri function for registering it as a smarty plugin.
 * 
 * @param type $params params from smarty code.
 * @param type $smarty reference to smarty object.
 * @return string full internet address.
 */
function smartyCreateUri($params, $smarty) {
    if (isset($params['controller'])) {
        $controller = $params['controller'];
        $action = isset($params['action']) ? $params['action'] : 'index';
        $plgParams = isset($params['params']) ? (is_array($params['params']) ? $params['params'] : array()) : array();
        
        return createUri($controller, $action, $plgParams);
    }
    return '';
}

?>