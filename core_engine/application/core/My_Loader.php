<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extended version of CI_Loader.
 * 
 * This one can load new type of table models, which are rows and collections.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

require_once APPPATH . 'core/abstract_table_row.php';
require_once APPPATH . 'core/abstract_table_collection.php';
require_once APPPATH . 'core/abstract_table_relation.php';

class My_Loader extends CI_Loader {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function table_row($table, $original_data = NULL) {
        if ($table == '') { return NULL; }
        $class_name = strtoupper($table[0]) . strtolower(substr($table, 1)) . '_table_row';
        $class_file = strtolower($table) . '_table_row.php';
        $class_path = APPPATH . 'table_models/' . $class_file;
        
        if (file_exists($class_path)) {
            if (!class_exists($class_name)) {
                require_once($class_path);
            }
            
            return new $class_name($original_data);
        }
        return NULL;
    }
    
    public function table_collection($table) {
        if ($table == '') { return NULL; }
        $class_name = strtoupper($table[0]) . strtolower(substr($table, 1)) . '_table_collection';
        $class_file = strtolower($table) . '_table_collection.php';
        $class_path = APPPATH . 'table_models/' . $class_file;
        
        if (file_exists($class_path)) {
            if (!class_exists($class_name)) {
                require_once($class_path);
            }
            
            return new $class_name();
        }
        return NULL;
    }
    
    public function table_relation($from_table, $to_table) {
        if ($from_table == '' || $to_table == '') { return NULL; }
        $class_name = strtoupper($from_table[0]) . strtolower(substr($from_table, 1)) . '_to_' . strtolower($to_table) . '_table_relation';
        $class_file = strtolower($from_table) . '_to_' . strtolower($to_table) . '_table_relation.php';
        $class_path = APPPATH . 'table_models/' . $class_file;
        
        if (file_exists($class_path)) {
            if (!class_exists($class_name)) {
                require_once($class_path);
            }
            
            return new $class_name();
        }
        return NULL;
    }
    
}

?>