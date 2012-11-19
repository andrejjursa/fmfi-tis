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

function smartyImageThumb($params, $smarty) {
    if (isset($params['image'])) {
        $image = $params['image'];
        $width = isset($params['width']) ? intval($params['width']) : NULL;
        $height = isset($params['height']) ? intval($params['height']) : NULL;
        
        return imageThumb($image, $width, $height);
    }
    return '';
}

function imageThumb($path_to_image, $max_width = NULL, $max_height = NULL) {
    if (trim($path_to_image) == '' || !file_exists($path_to_image)) { return ''; }
    $CI =& get_instance();
    
    $base_url = Abstract_common_controller::getBaseUrl();
    
    $original_full_path = $base_url . ($path_to_image[0] == '/' ? substr($path_to_image, 1) : $path_to_image);
    
    if (is_null($max_width) && is_null($max_height)) {
        return $original_full_path;
    }
    
    $path_info = pathinfo($path_to_image);
    
    $cache_dir = $path_info['dirname'];
    $cache_dir = substr($cache_dir, -1) == '/' ? $cache_dir . 'cache' : $cache_dir . '/cache';
    $new_image_name = $path_info['filename'] . '_w' . (is_null($max_width) ? 'NULL' : $max_width) . '_h' . (is_null($max_height) ? 'NULL' : $max_height) . '.' . $path_info['extension'];
    $new_image_path = $path_info['dirname'];
    $new_image_path = $cache_dir . '/' . $new_image_name;
    if (!file_exists($new_image_path) || filemtime($new_image_path) < filemtime($path_to_image)) {    
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path_to_image;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['new_image'] = $new_image_path;
        if (!is_null($max_width)) { $config['width'] = $max_width; }
        if (!is_null($max_height)) { $config['height'] = $max_height; }

        $CI->load->library('image_lib');

        $CI->image_lib->initialize($config);

        $CI->image_lib->resize();
    }
    
    $new_image_basepath = $base_url . ($new_image_path[0] == '/' ? substr($new_image_path, 1) : $new_image_path);
    
    return $new_image_basepath;
}

?>