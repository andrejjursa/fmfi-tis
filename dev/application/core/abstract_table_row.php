<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH . 'core/abstract_table_core.php';

/**
 * Abstract class for table rows.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */
class Abstract_table_row extends Abstract_table_core {
    
    /**
     * @var string name of table represented by this class.
     */
    protected $table_name = NULL;
    
    /**
     * @var string name of column in table, which is primary key.
     */
    protected $primary_field = 'id';
    
    /**
     * @var array<mixed> currently unsaved pairs of column => value in one row of table represented by this class.
     */
    protected $data = array();
    
    /**
     * @var array<mixed> current pairs of column => value in one row of table represented by this class.
     */
    protected $original_data = array();
    
    /**
     * Constructor of _table_row classes.
     * 
     * @param array<mixed> array of original values or NULL for leaving original values blank.
     */
    public function __construct($original_data = NULL) {
        if (!is_null($original_data)) { $this->original_data = $original_data; }
        
        $this->determineTableColumns();
        
        $this->init();
    }
    
    /**
     * This function loads one row of database table by given value of primary key (primary index).
     * 
     * @param integer $id integer value of primary index in table, should be positive value.
     * @return bool return TRUE when table row is found and loaded, FALSE otherwise.
     */
    public function load($id) {
        if ($this->isInsideTemplate()) {
            throw new exception(get_class($this) . ': Can\'t load table row inside template view!');
        }
        $this->load->database();
        
        $this->data = array();
        $this->original_data = array();
        $this->resetRelations();
        
        $query = $this->db->get_where($this->table_name, array($this->primary_field => $id), 1);
        $this->original_data = $query->row_array();
        
        $query->free_result();
        
        return count($this->original_data) > 0;
    }
    
    /**
     * This function loads one row of database table by given condition.
     * 
     * Condition can be string of WHERE clause in SQL query, or array of values column => value,
     * this array is applied each row to active record where method: $this->db->where(column, value).
     * 
     * Function can have more than one parameter, these parameters are replacements of question marks
     * in WHERE clause, they must be in correct order.
     * 
     * @param string|array<mixed> where clause.
     * @return bool return TRUE when only one table row matches condition and is loaded, FALSE otherwise.
     */
    public function loadBy() {
        if ($this->isInsideTemplate()) {
            throw new exception(get_class($this) . ': Can\'t load table row inside template view!');
        }
        if (func_num_args() == 0) {
            throw new exception(get_class($this) . ': Method loadBy() require at least one argument!');
        }
        
        $this->load->database();
        
        $where = func_get_arg(0);
        if (is_string($where)) {
            $sql = 'SELECT * FROM ' . $this->db->protect_identifiers($this->table_name) . ' WHERE ' . $where . ';';
            
            $this->data = array();
            $this->original_data = array();
            $this->resetRelations();
            
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
            $this->resetRelations();
            
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
    
    /**
     * Saves assigned data to database table.
     * 
     * If there is not any data from original load(), loadBy() or setId() call, new record will be inserted to table,
     * otherwise existing record will be updated.
     * 
     * After save is completed, data from table will be loaded again.
     * 
     * @return bool TRUE, if new or existing record is inserted / updated, FALSE otherwise.
     */
    public function save() {
        if ($this->isInsideTemplate()) {
            throw new exception(get_class($this) . ': Can\'t save table row inside template view!');
        }
        if (count($this->data) == 0) { return FALSE; }
        
        $id = isset($this->original_data[$this->primary_field]) ? $this->original_data[$this->primary_field] : NULL;
        
        $this->load->database();
        
        if (in_array('tstamp', $this->_getKnownFields())) {
            $this->db->set('tstamp', 'CURRENT_TIMESTAMP', FALSE);    
        }
        
        if (is_null($id) && in_array('crdate', $this->_getKnownFields())) {
            $this->db->set('crdate', 'CURRENT_TIMESTAMP', FALSE);
        }
        
        foreach($this->data as $field => $value) {
            if ($value instanceof Nonescape_data) {
                $this->db->set($field, $value, FALSE);
            } else {
                $this->db->set($field, $value);
            }
        }
        
        $old_id = $id;
        
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
        
        $this->load->model('Logs');
        if (is_null($old_id)) {
            $this->Logs->addLog('New record in table "' . $this->table_name . '".', array('type' => 'insert', 'new_data' => $this->data, 'new_id' => $id, 'sql' => $this->db->last_query()));
        } else {
            $this->Logs->addLog('Changed record in table "' . $this->table_name . '" with id ' . $old_id . '.', array('type' => 'update', 'original_data' => $this->original_data, 'new_data' => $this->data, 'sql' => $this->db->last_query()));
        }
        
        $this->load($id);
        
        return TRUE;
    }
    
    /**
     * This function deletes table row, but only if there is valid primary index.
     * You must first call load(), loadBy() or setId() methods.
     * 
     * @return bool TRUE, when table row is deleted, FALSE otherwise.
     */
    public function delete() {
        if ($this->isInsideTemplate()) {
            throw new exception(get_class($this) . ': Can\'t delete table row inside template view!');
        }
        if (isset($this->original_data[$this->primary_field])) {
            $this->load->database();
            if ($this->db->delete($this->table_name, array($this->primary_field => $this->original_data[$this->primary_field]))) {
                $this->load->model('Logs');
                $this->Logs->addLog('Deleted record from table "' . $this->table_name . '" with id ' . $this->getId() .  '.', array('type' => 'delete', 'original_data' => $this->original_data, 'sql' => $this->db->last_query()));
                @$this->onDelete();
                $this->data = array();
                $this->original_data = array();
                return TRUE;
            }
        }
        return FALSE;
    }
    
    /**
     * Multipurpose function, based on given arguments.
     * 
     * If you omit both arguments, this function returns array of original data from table row.
     * If you specify first argument as string and leaves second intact, you will receive value of given column from table row.
     * If you specify first argument as array of string => string | bool | numeric | Nonescape_data and leaves second intact,
     * you will set new values of table column from given array and function returns reference to this object.
     * If you specify both arguments, first must be string and second can be string | bool | numeric | Nonescape_data, you will
     * set new value of table column for given column and value, and you will receive reference to this object.
     * 
     * Any other combination of arguments can trigger error or do nothing, just return reference to this object.
     * 
     * @param NULL|string|array<mixed> $column nothing, column name or array of new column values.
     * @param NULL|string|bool|numeric|Nonescape_data $new_value nothing or new value of column.
     * @return mixed can return array of original data, value of column, NULL or reference to this object.
     */
    public function data($column = NULL, $new_value = NULL) {
        if (is_null($column) && is_null($new_value)) {
            return $this->original_data;
        } else if (!is_null($column) && is_null($new_value)) {
            if (is_string($column)) {
                return isset($this->original_data[$column]) ? $this->original_data[$column] : (!in_array($column, $this->_getKnownFields()) && method_exists($this, 'get' . $column) ? call_user_func(array($this, 'get' . $column)) : NULL);    
            } else if (is_array($column)) {
                if (count($column)) {
                    foreach ($column as $field => $value) {
                        $this->data($field, $value);
                    }
                }
            }
        } else if (!is_null($column) && !is_null($new_value)) {
            if (is_string($column)) {
                if (in_array($column, $this->_getKnownFields())) { 
                    if (is_string($new_value) || is_bool($new_value) || is_numeric($new_value) || $new_value instanceof Nonescape_data) {
                        if ($this->isInsideTemplate()) {
                            throw new exception(get_class($this) . ': Can\'t set table row column value inside template view!');
                        }
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
    
    /**
     * Makes virtual set<Column>($value) and get<Column>() public method for
     * accessing and changing table row data.
     * 
     * @param string $name method name.
     * @param array<mixed> $arguments method arguments.
     * @return mixed can return column value or reference to this object.
     */ 
    public function __call($name, $arguments) {
        if (!method_exists($this, $name)) {
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
    }
    
    /**
     * Returns value of primary key (primary index).
     * 
     * @return integer primary key value.
     */
    public function getId() {
        return $this->data($this->primary_field);
    }
    
    /**
     * Sets new value of primary key (primary index).
     * 
     * @param integer $id new id for this table.
     * @return Abstract_table_row reference to this object.
     */
    public function setId($id) {
        return $this->data($this->primary_field, $id);
    }
    
    /**
     * Returns name of this table.
     * 
     * @return string table name.
     */
    public function getTableName() {
        return $this->table_name;
    }
    
    /**
     * Returns all available data data to editor.
     * This method does not returns data from relations!
     * For relation specified data to be fetched, this method must be overriden.
     * 
     * @return array<mixed> data.
     */
    public function getDataForEditor() {
        return $this->data();
    }
    
    /**
     * Sets the date to be saved after editing in editor.
     * This method does not manipulate with relation.
     * If you need to manipulate with relations, this method must be overriden.
     * 
     * @param array<mixed> $formdata data from editing form.
     * @return Abstract_table_row reference to this object.
     */
    public function prepareEditorSave($formdata) {
        $this->data($formdata);
        return $this;
    }
    
    /**
     * Simple function called after delete of this table row record.
     * 
     * @return void
     */
    protected function onDelete() {}
    
    /**
     * Function which can initialize relations.
     * 
     * Called automatically in class constructor.
     * 
     * @return void
     */
    protected function init() {
        
    }
    
    /**
     * Function which can reset relations data.
     * 
     * Called automatically in load() and loadBy() methods.
     * 
     * @return void
     */
    protected function resetRelations() {
        
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
            $this->table_name = strtolower(substr($class_name, 0, -10));
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

/**
 * This class serves as encapsulation for non escaped data, i.e. for SET column = column + 1, which
 * without use of this class will produce SET `column` = 'column + 1'.
 * 
 * @author Andrej Jursa
 * @version 1.0
 * @package Abstract
 * @subpackage Core
 * 
 */
class Nonescape_data {
    
    /**
     * @var string expression to be used as column value
     */
    private $expression = NULL;
    
    /**
     * Constructor of class with expession.
     * 
     * @param string $expression expression.
     */
    public function __construct($expression) {
        if (is_string($expression) || is_bool($expression) || is_numeric($expression)) {
            $this->expression = $expression;
        }
    }
    
    /**
     * Returns expression string.
     * 
     * @return string expression.
     */
    public function __toString() {
        return $this->expression;
    }
    
}

?>