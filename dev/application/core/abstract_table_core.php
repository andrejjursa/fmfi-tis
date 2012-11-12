<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for all table model classes.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
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
}

?>