<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for table rows.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

class Abstract_table_row {
    
    /**
     * @var string name of table represented by this class
     */
    protected $table_name = NULL;
    
    /**
     * @var string name of column in table, which is primary key
     */
    protected $primary_field = 'id';
    
    /**
     * @var string known columns in table represented by this class
     */
    protected static $table_fields = NULL;
    
    /**
     * @var array<mixed> currently unsaved pairs of column => value in one row of table represented by this class
     */
    protected $data = array();
    
    /**
     * @var array<mixed> current pairs of column => value in one row of table represented by this class
     */
    protected $original_data = array();
    
    public function __construct($original_data = NULL) {
        if (!is_null($original_data)) { $this->original_data = $original_data; }
        
        $this->determineTableColumns();
    }
    
    public function load($id) {
        $this->load->database();
        
        $this->data = array();
        $this->original_data = array();
        
        $query = $this->db->get_where($this->table_name, array($this->primary_field => $id), 1);
        $this->original_data = $query->row_array();
        
        $query->free_result();
        
        return count($this->original_data) > 0;
    }
    
    public function loadBy() {
        if (func_num_args() == 0) {
            throw new exception(get_class($this) . ': Method loadBy() require at least one argument!');
        }
        
        $this->load->database();
        
        $where = func_get_arg(0);
        if (is_string($where)) {
            $sql = 'SELECT * FROM ' . $this->db->protect_identifiers($this->table_name) . ' WHERE ' . $where . ';';
            
            $this->data = array();
            $this->original_data = array();
            
            $replaces = func_get_args();
            unset($replaces[0]);
            
            $query = $this->db->query($sql, $replaces);
            
            if ($query->num_rows() == 1) {
                $this->original_data = $query->row_array();
                $query->free_result();
                return TRUE;
            }
            return FALSE;
        } else if (is_array($where)) {
            if (count($where) == 0) {
                return FALSE;
            }
            
            $this->db->select()->from($this->table_name);
            
            foreach ($where as $condition => $value) {
                if (is_string($condition) && (is_string($value) || is_bool($value) || is_numeric($value))) {
                    $this->db->where($condition, $value);
                } else {
                    throw new exception(get_class($this) . ': Bad types of where clause conditions! Allowed only string => string | bool | numeric.');
                }
            }
            
            $this->data = array();
            $this->original_data = array();
            
            $query = $this->db->get();
            
            if ($query->num_rows() == 1) {
                $this->original_data = $query->row_array();
                $query->free_result();
                return TRUE;
            }
            return FALSE;
        } else {
            throw new exception(get_class($this) . ': WHERE clause must be string of array of pairs: field => value!');    
        }
    }
    
    public function save() {
        if (count($this->data) == 0) { return FALSE; }
        
        $id = isset($this->original_data[$this->primary_field]) ? $this->original_data[$this->primary_field] : NULL;
        
        $this->load->database();
        
        if (in_array('tstamp', self::$table_fields)) {
            $this->db->set('tstamp', 'CURRENT_TIMESTAMP', FALSE);    
        }
        
        if (is_null($id) && in_array('crdate', self::$table_fields)) {
            $this->db->set('crdate', 'CURRENT_TIMESTAMP', FALSE);
        }
        
        foreach($this->data as $field => $value) {
            if ($value instanceof Nonescape_data) {
                $this->db->set($field, $value, FALSE);
            } else {
                $this->db->set($field, $value);
            }
        }
        
        if (is_null($id)) {
            if ($this->db->insert($this->table_name)) {
                $id = $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
            $this->db->where($this->primary_field, $id);
            if (!$this->db->update($this->table_name)) {
                return FALSE;
            }
        }
        
        $this->load($id);
        
        return TRUE;
    }
    
    public function delete() {
        if (isset($this->original_data[$this->primary_field])) {
            $this->load->database();
            if ($this->db->delete($this->table_name, array($this->primary_field => $this->original_data[$this->primary_field]))) {
                $this->data = array();
                $this->original_data = array();
                return TRUE;
            }
        }
        return FALSE;
    }
    
    public function data($column = NULL, $new_value = NULL) {
        if (is_null($column) && is_null($new_value)) {
            return $this->original_data;
        } else if (!is_null($column) && is_null($new_value)) {
            if (is_string($column)) {
                return isset($this->original_data[$column]) ? $this->original_data[$column] : NULL;    
            } else if (is_array($column)) {
                if (count($column)) {
                    foreach ($column as $field => $value) {
                        $this->data($field, $value);
                    }
                }
            }
        } else if (!is_null($column) && !is_null($new_value)) {
            if (is_string($column)) {
                if (in_array($column, self::$table_fields)) { 
                    if (is_string($new_value) || is_bool($new_value) || is_numeric($new_value) || $new_value instanceof Nonescape_data) {
                        if ($column == $this->primary_field && isset($this->original_data[$this->primary_field])) { 
                            throw new exception(get_class($this) . ': Can\'t change existing id from ' . $this->original_data[$this->primary_field] . ' to ' . $new_value . '!');
                        } else if ($column == 'tstamp') {
                            throw new exception(get_class($this) . ': Can\'t change time of last modification!');
                        } else if ($column == 'crdate') {
                            throw new exception(get_class($this) . ': Can\'t change time of record creation!');
                        }
                        
                        if ($column == $this->primary_field) {
                            $old_data = $this->data;
                            if (!$this->load($new_value)) {
                                throw new exception(get_class($this) . ': There is no primary key ' . $new_value . ' in table ' . $this->table_name . '!');
                            }
                            $this->data = $old_data;
                            return $this;   
                        }
                        
                        $this->data[$column] = $new_value;
                    } else {
                        throw new exception(get_class($this) . ': Can\'t handle supplied value! It is of wrong type. Allowed types are: string, boolean, numeric and Nonescape_data');
                    }
                } /*else {
                    throw new exception(get_class($this) . ': Unknown column "' . $column . '" in table ' . $this->table_name . '!');
                }*/
            } else {
                throw new exception(get_class($this) . ': Column name must be string!');
            }
        }
        return $this;
    }
    
    public function __call($name, $arguments) {
        if (substr($name, 0, 3) == 'get') {
            $field = strtolower(substr($name, 3));
            return $this->data($field);
        } else if (substr($name, 0, 3) == 'set') {
            $field = strtolower(substr($name, 3));
            if (count($arguments) == 0) {
                throw new exception(get_class($this) . ': Method ' . $name . '() must have one argument!');
            }
            return $this->data($field, $arguments[0]);
        }
    }
    
    protected function determineTableName() {
        if (is_null($this->table_name)) {
            $class_name = get_class($this);
            $this->table_name = strtolower(substr($class_name, 0, -10));
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

class Nonescape_data {
    
    private $expression = NULL;
    
    public function __construct($expression) {
        if (is_string($expression) || is_bool($expression) || is_numeric($expression)) {
            $this->expression = $expression;
        }
    }
    
    public function __toString() {
        return $this->expression;
    }
    
}

?>