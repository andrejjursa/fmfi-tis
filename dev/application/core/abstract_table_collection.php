<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for collection of table rows.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

require_once APPPATH . 'core/abstract_table_core.php';

class Abstract_table_collection extends Abstract_table_core {
    
    /**
     * @var string name of table represented by this class.
     */
    protected $table_name = NULL;
    
    /**
     * @var array<Abstract_table_row> array of table rows.
     */
    protected $rows = array();
    
    /**
     * @var array<integer> array of table rows primary indexes.
     */
    protected $ids = array();
    
    /**
     * @var CI_DB_active_record active record class of codeigniter.
     */
    protected $query = NULL;
    
    /**
     * Class constructor.
     */
    public function __construct() {
        $this->determineTableColumns();
        $this->reset();
    }
    
    /**
     * Runs active record query and fills rows with table rows.
     * 
     * @return Abstract_table_collection reference to this object.
     */
    public function execute() {
        $query = $this->query->get();
        
        $rows = $query->result_array();
        $query->free_result();
        
        $this->rows = array();
        $this->ids = array();
        
        if (count($rows) > 0) {
            foreach($rows as $row) {
                $object = $this->load->table_row($this->table_name, $row);
                if (is_null($object)) {
                    return $this;
                }
                $this->rows[] = $object;
                $this->ids[] = $object->getId();
            }
        }
        
        $this->reset();
        
        return $this;
    }
    
    /**
     * Add sorting into query.
     * 
     * @param string $column column, by which will be result set sorted.
     * @param string $direction direction of sorting, can be asc, desc or random.
     * @return Abstract_table_collection reference to this object.
     */
    public function orderBy($column, $direction) {
        if (in_array($column, $this->_getKnownFields())) {
            $this->query->order_by($column, $direction);
        } else if ($column == '' && $direction == 'random') {
            $this->query->order_by('', 'random');
        }
        return $this;
    }
    
    /**
     * Sets limits for result set.
     * 
     * @param integer $value count of rows in result set.
     * @param integer $offset offset of rows, count from 0.
     * @return Abstract_table_collection reference to this object.
     */
    public function limit($value, $offset = 0) {
        if (is_integer($value) && is_integer($offset)) {
            $this->query->limit($value, $offset);
        }
        return $this;
    }
    
    /**
     * This function will reset query to default.
     * 
     * @return Abstract_table_collection reference to this object.
     */
    public function reset() {
        $this->query = $this->load->database('', TRUE);
        $this->query->from($this->table_name);
        
        return $this;
    }
    
    /**
     * Returns array of table rows as instance of extended Abstract_table_row class.
     * 
     * @return array<Abstract_table_row> table rows.
     */
    public function get() {
        return $this->rows;
    }
    
    /**
     * Returns array of table rows primary indexes as array of integers.
     * 
     * @return array<integer> array of table rows primary indexes.
     */
    public function allIds() {
       return $this->ids; 
    }
    
    /**
     * Returns count of table rows.
     * 
     * @return integer count of table rows.
     */
    public function count() {
        $queryclone = clone $this->query;
        return $queryclone->count_all_results();
    }
    
    /**
     * This function reads name of database table from name of class, but only
     * when table_name is set to NULL.
     * 
     * @return void
     */
    protected function determineTableName() {
        if (is_null($this->table_name)) {
            $class_name = get_class($this);
            $this->table_name = strtolower(substr($class_name, 0, -17));
        }
    }
    
    /**
     * This function will read table columns from database table, bot only
     * when this columns are not known.
     * 
     * @return void
     */
    protected function determineTableColumns() {
        $this->determineTableName();
        if (is_null($this->_getKnownFields())) {
            $this->load->database();
            $this->_setKnownFields($this->db->list_fields($this->table_name));    
        }
    }
    
    /**
     * This function will return array of known table columns for this table, or NULL when
     * they are not read from database.
     * 
     * @return array<string>|NULL table column or NULL.
     */
    protected function _getKnownFields() {
        return isset($GLOBALS['TABLE_KNOWN_FIELDS'][$this->table_name]) ? $GLOBALS['TABLE_KNOWN_FIELDS'][$this->table_name] : NULL;
    }
    
    /**
     * This function will save array of known table columns to global memory.
     * 
     * @param array<string> $fields array of known table columns.
     * @return void
     */
    protected function _setKnownFields($fields) {
        $GLOBALS['TABLE_KNOWN_FIELDS'][$this->table_name] = $fields;
    }
}

?>