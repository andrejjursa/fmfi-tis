<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extended version of CI_Loader.
 * 
 * This one can load new type of table models, which are rows and collections.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */

require_once APPPATH . 'core/abstract_table_row.php';
require_once APPPATH . 'core/abstract_table_collection.php';
require_once APPPATH . 'core/abstract_table_relation.php';

class My_Loader extends CI_Loader {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Create and return new instance of table_row class.
     * 
     * @param string $table table name.
     * @param array<mixed> $original_data original data passed to object.
     * @return Abstract_table_row instance of table_row class.
     */
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
    
    /**
     * Create and return new instance of table_collection class.
     * 
     * @param string $table table name.
     * @return Abstract_table_collection instance of table_collection class.
     */
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
    
    /**
     * Create and return new instance of table_relation class.
     * 
     * @param string $from_table table name of local table.
     * @param string $to_table table name of foreign table.
     * @return Abstract_table_relation instance of table_relation class.
     */
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