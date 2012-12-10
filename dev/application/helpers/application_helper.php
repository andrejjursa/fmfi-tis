<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

/**
 * @package AppHelpers
 */

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

/**
 * Mask for imageThumb for smarty (can be registered as a template function).
 * 
 * @param array<mixed> $params parameters from smarty tag.
 * @param Smarty_Internal_TemplateBase $smarty smarty reference.
 */
function smartyImageThumb($params, $smarty) {
    if (isset($params['image'])) {
        $image = $params['image'];
        $width = isset($params['width']) ? intval($params['width']) : NULL;
        $height = isset($params['height']) ? intval($params['height']) : NULL;
        
        return imageThumb($image, $width, $height);
    }
    return '';
}

/**
 * Creates thumbnail of image.
 * It does not create thumbnail if max width and height are NULL.
 * 
 * @param string $image path to image.
 * @param integer @max_width maximum width of thumbnail or NULL.
 * @param integer $max_height maximum height of thumbnail or NULL.
 * @return string path to thumbnail.
 */
function imageThumb($image, $max_width = NULL, $max_height = NULL) {
    if (trim($image) == '') { return ''; }
    $path_to_image = $image[0] == '/' || $image[0] == '\\' ? substr($image, 1) : $image;
    if (!file_exists($path_to_image)) { return ''; }
    
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

/**
 * Deletes image file and all thumbnails this image has cached.
 * Deletes only image file located inside public/uploads directory, for security reasons.
 * 
 * @param string $image path to image.
 * @return void
 */
function deleteImageAndThumbs($image) {
    if (trim($image) == '') { return; }
    $path_to_image = trim($image, '\\/');
    if (!file_exists($path_to_image)) { return; }
    if (substr($path_to_image, 0, 14) != 'public/uploads') { return; }
    
    $path_info = pathinfo($path_to_image);
    
    $cachedir = trim($path_info['dirname'], '/\\') . '/cache';
    
    @unlink($path_to_image);
    
    $filename_regexp = '/' . str_replace('.', '\\.', $path_info['filename']) . '_w([0-9]+|NULL)_h([0-9]+|NULL)\\.' . $path_info['extension'] . '/'; 
    
    if (is_dir($cachedir) && !empty($cachedir)) {
        $files_in_cache = scandir($cachedir);    
        foreach ($files_in_cache as $file) {
            if (preg_match($filename_regexp, $file)) {
                @unlink($cachedir . '/' . $file);
            }
        }
    }
}

function smartyFormError($params, $smarty) {
    $CI =& get_instance();
    $CI->load->library('form_validation');
    $CI->load->helper('form');
    $default = array('field'=>'', 'prewrap' => '', 'postwrap' => '');
    $params = array_merge($default, $params);
    $error_message = (form_error(@$params['field'], ' ', ' '));
    if (!empty($error_message)) {
        echo $params['prewrap'] . $error_message . $params['postwrap'];
    }
}

function explodeSqlFile($fileName){
	if(!is_file($fileName)){
		return false;
	}
	
	if($sql = file_get_contents($fileName)){
		$return = array();
		foreach(explode(";\r\n", $sql) as $sqlQuery){
			$sqlQuery = trim($sqlQuery);
			if($sqlQuery){
				$return[] = $sqlQuery;
			}
		}
		return $return;
	}
	return false;
}

function rrmdir($dir, $removeParent = true){
	if(!is_dir($dir)){
		return false;
	}
	
	foreach(glob($dir . '/*') as $file) {
		if(is_dir($file)){
			rrmdir($file);
		}
		else{
			unlink($file);
		}
	}
	if($removeParent){
		rmdir($dir);
	}
 }

 
 function generateToken() {
     $veta = "Ihla pichla Ivana do nohy'.";
     
     $dlzka_vstupu_cryptovania = 10;
     $veta_len = strlen($veta);
     $vystup = date("d");
     for ($i = 0; $i <= $dlzka_vstupu_cryptovania; $i++) {
         $vystup .= $veta[rand(0, $veta_len - 1)];
     }
     
     return md5($vystup);
 }
 
 
?>