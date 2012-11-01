<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for collection of table rows.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

class Abstract_table_collection {
    
    protected $table_name = NULL;
    
    protected $rows = array();
    
    protected $query = NULL;
    
    /**
     * @var string known columns in table represented by this class
     */
    protected static $table_fields = NULL;
    
    public function __construct() {
        $this->determineTableColumns();
        $this->reset();
    }
    
    public function execute() {
        $query = $this->query->get();
        
        $rows = $query->result_array();
        $query->free_result();
        
        $this->rows = array();
        
        if (count($rows) > 0) {
            foreach($rows as $row) {
                $object = $this->load->table_row($this->table_name, $row);
                if (is_null($object)) {
                    return $this;
                }
                $this->rows[] = $object;
            }
        }
        
        $this->reset();
        
        return $this;
    }
    
    public function orderBy($column, $direction) {
        if (in_array($column, self::$table_fields)) {
            $this->query->order_by($column, $direction);
        } else if ($column == '' && $direction == 'random') {
            $this->query->order_by('', 'random');
        }
        return $this;
    }
    
    public function limit($value, $offset = 0) {
        if (is_integer($value) && is_integer($offset)) {
            $this->query->limit($value, $offset);
        }
        return $this;
    }
    
    public function reset() {
        $this->query = $this->load->database('', TRUE);
        $this->query->from($this->table_name);
        
        return $this;
    }
    
    public function get() {
        return $this->rows;
    }
    
    public function count() {
        $queryclone = clone $this->query;
        $queryclone->select('COUNT(*) as ' . $queryclone->protect_identifiers('count_of_rows'), FALSE);
        
        $query = $queryclone->get();
        $row = $query->row();
        $query->free_result();
        
        return $row->count_of_rows;
    }
    
    protected function determineTableName() {
        if (is_null($this->table_name)) {
            $class_name = get_class($this);
            $this->table_name = strtolower(substr($class_name, 0, -17));
        }
    }
    
    protected function determineTableColumns() {
        $this->determineTableName();
        if (is_null(self::$table_fields)) {
            $this->load->database();
            self::$table_fields = $this->db->list_fields($this->table_name);    
        }
    }
    
    /**
	 * __get
	 *
	 * Allows table models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param string
	 * @access private
	 */
	function __get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
}

?>