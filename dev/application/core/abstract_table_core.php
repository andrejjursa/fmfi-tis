<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for all table model classes.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */
class Abstract_table_core {
    /**
	 * __get
	 *
	 * Allows table models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param string $key
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
    
    /**
     * Determines, if this class is called inside template view.
     * 
     * @return boolean TRUE, when this class is called inside template view, FALSE otherwise.
     */
    protected function isInsideTemplate() {
        $debug_array = debug_backtrace();
        
        for ($i=0;$i<count($debug_array);$i++) {
            $debug_item = $debug_array[$i];
            if (isset($debug_item['class'])) {
                if ($debug_item['class'] == 'Smarty' || $debug_item['class'] == 'Smarty_Internal_TemplateBase' || $debug_item['class'] == 'Smarty_Internal_Data' || $debug_item['class'] == 'CI_Parser' || $debug_item['class'] == 'My_Parser') {
                    return TRUE;
                } else if ($debug_item['class'] == 'CI_Loader' || $debug_item['class'] == 'My_Loader') {
                    if (isset($debug_item['function']) && $debug_item['function'] == 'view') {
                        return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }
    
    /**
     * Determines, if current call is from within some method of this class.
     * 
     * @param string $method_name name of method.
     * @return boolean TRUE or FALSE if not called from method.
     */
    protected function isCalledFrom($method_name) {
        $class_name = get_class($this);
        $debug_array = debug_backtrace();
        
        if (count($debug_array)) {
            foreach($debug_array as $debug_item) {
                if (isset($debug_item['function']) && isset($debug_item['object']) && strtolower($debug_item['function']) == strtolower($method_name) && get_class($debug_item['object']) == $class_name) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
}

?>