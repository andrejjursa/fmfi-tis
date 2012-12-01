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
require_once APPPATH . 'core/abstract_editor_classes.php';

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
     * @var string name of primary key field.
     */
    protected $primary_id = 'id';
    
    /**
     * @var array<mixed> settings for editing grid.
     */
    private $grid_settings = array();
    
    /**
     * @var array<mixed> settings for record editor (new/edit actions).
     */
    private $editor_settings = array();
    
    /**
     * @var string last executed query.
     */
    private $last_query = '';
    
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
        $this->last_query = $this->query->last_query();
        
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
    
    public function filterIs($field, $value, $operator = '', $use_or = FALSE) {
        if (in_array($field, $this->_getKnownFields())) {
            if ($use_or) {
                $this->query->or_where($field . ' ' . $operator, $value);
            } else {
                $this->query->where($field . ' ' . $operator, $value);    
            }
        }
        return $this;
    }
    
    public function filterLike($field, $value, $escape = 'both', $use_or = FALSE) {
        if (in_array($field, $this->_getKnownFields())) {
            if ($use_or) {
                $this->query->or_like($field, $value, $escape);
            } else {
                $this->query->like($field, $value, $escape);   
            }
        }
        return $this;
    }
    
    public function filterIn($field, $values, $not = FALSE, $use_or = FALSE) {
        if (in_array($field, $this->_getKnownFields()) && is_array($values)) {
            if ($use_or) {
                if ($not) {
                    $this->query->or_where_not_in($field, $values);
                } else {
                    $this->query->or_where_in($field, $values);       
                }
            } else {
                if ($not) {
                    $this->query->where_not_in($field, $values);
                } else {
                    $this->query->where_in($field, $values);       
                }
            }
        }
        return $this;
    }
    
    public function filterCustomWhere($where) {
        if (trim($where) != '') {
            $this->query->where(trim($where));
        }
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
     * Returns total number of pages.
     * 
     * @param integer $rows_per_page number of rows displayed on one page.
     * @return integer number of pages.
     */
    public function getPagesCount($rows_per_page = 20) {
        if (intval($rows_per_page) == 0) { return 1; }
        
        $count_of_rows = $this->count();
        
        return ceil($count_of_rows / intval($rows_per_page));
    }
    
    /**
     * Set appropriate limits to the query by arguments.
     * 
     * @param integer $page number of page.
     * @param integer $rows_per_page number of rows displayed on one page.
     * @return Abstract_table_collection reference to this object.
     */
    public function paginate($page, $rows_per_page = 20) {
        if (intval($rows_per_page) == 0) { return $this; } 
        $pages_count = $this->getPagesCount($rows_per_page);
        
        $_page = (intval($page) >= 1 && intval($page) <= $pages_count) ? intval($page) : 1;
        
        $this->limit(intval($rows_per_page), ($_page - 1) * intval($rows_per_page));
        
        return $this;
    }
    
    public function primaryIdField() {
        return $this->primary_id;
    }
    
    final public function getGridSettings() {
        $this->defaultEditingGrid();
        $this->gridSettings();
        return $this->grid_settings;
    }
    
    final public function getEditorSettings() {
        $this->defaultEditorSettings();
        $this->editorSettings();
        return $this->editor_settings;
    }
    
    /**
     * Definitions for grid in admin editor.
     */
    protected function gridSettings() {
        
    }
    
    /**
     * Definitions for record form in admin editor.
     */
    protected function editorSettings() {
        
    }
    
    /**
     * Adds new tab for record editor in admin editor.
     * 
     * @param editorTab $tab editor tab.
     */
    protected function addEditorTab(editorTab $tab) {
        $this->editor_settings['tabs'][] = $tab;
        return $this;
    }
    
    /**
     * Set name of table in admin editor.
     *
     * @param string $name name of table.
     */
    protected function setGridTableName($name) {
        if (is_string($name)) {
            $this->grid_settings['table_name'] = $name;
        }
    }
    
    /**
     * Add gridField class to list of field of grid view in editor.
     * 
     * @param gridField $field definition of field.
     * @return Abstract_table_collection reference to this object.
     */
    protected function addGridField(gridField $field) {
        $field_index = $field->getField();
        
        if (!isset($this->grid_settings['fields'][$field_index])) {
            $this->grid_settings['fields'][$field_index] = $field;
        }
        
        return $this;
    }
    
    /**
     * Enable or disable grid view for derived table collection.
     * 
     * @param boolean $status TRUE for enable grid view, FALSE for disable.
     * @return Abstract_table_collection reference to this object.
     */
    protected function enableGrid($status = TRUE) {
        $this->grid_settings['enabled'] = is_bool($status) ? $status : FALSE;
        return $this;
    }
    
    /**
     * Enable or disable new record tool.
     * 
     * @param boolean $status TRUE or FALSE for enabled or disabled state.
     * @param string $title button title.
     * @return Abstract_table_collection reference to this object.
     */
    protected function enableNewRecord($status = TRUE, $title = 'Nový záznam') {
        $this->grid_settings['operations']['new_record'] = is_bool($status) ? $status : FALSE;
        $this->grid_settings['operations']['new_record_title'] = $title;
        return $this;
    }
    
    /**
     * Enable or disable edit record tool.
     * 
     * @param boolean $status TRUE or FALSE for enabled or disabled state.
     * @param string $title button title.
     * @return Abstract_table_collection reference to this object.
     */
    protected function enableEditRecord($status = TRUE, $title = 'Upraviť') {
        $this->grid_settings['operations']['edit_record'] = is_bool($status) ? $status : FALSE;
        $this->grid_settings['operations']['edit_record_title'] = $title;
        return $this;
    }
    
    /**
     * Enable or disable delete record tool.
     * 
     * @param boolean $status TRUE or FALSE for enabled or disabled state.
     * @param string $title button title.
     * @return Abstract_table_collection reference to this object.
     */
    protected function enableDeleteRecord($status = TRUE, $title = 'Vymazať') {
        $this->grid_settings['operations']['delete_record'] = is_bool($status) ? $status : FALSE;
        $this->grid_settings['operations']['delete_record_title'] = $title;
        return $this;
    }
    
    /**
     * Enable or disable preview record tool.
     * 
     * @param boolean $status TRUE or FALSE for enabled or disabled state.
     * @param string $title button title.
     * @return Abstract_table_collection reference to this object.
     */
    protected function enablePreviewRecord($status = TRUE, $title = 'Náhlad') {
        $this->grid_settings['operations']['preview_record'] = is_bool($status) ? $status : FALSE;
        $this->grid_settings['operations']['preview_record_title'] = $title;
        return $this;
    }
    
    public function isNewRecordEnabled() {
        return isset($this->grid_settings['operations']['new_record']) ? $this->grid_settings['operations']['new_record'] : FALSE;
    }
    
    public function isEditRecordEnabled() {
        return isset($this->grid_settings['operations']['edit_record']) ? $this->grid_settings['operations']['edit_record'] : FALSE;
    }
    
    public function isDeleteRecordEnabled() {
        return isset($this->grid_settings['operations']['delete_record']) ? $this->grid_settings['operations']['delete_record'] : FALSE;
    }
    
    public function isPreviewRecordEnabled() {
        return isset($this->grid_settings['operations']['preview_record']) ? $this->grid_settings['operations']['preview_record'] : FALSE;
    }
    
    public function lastQuery() {
        return $this->last_query;
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
    
    private function defaultEditingGrid() {
        $this->grid_settings = array();
        
        $id = gridField::newGridField();
        $id->setField($this->primary_id)->setName('ID')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_NUMBER);
        $this->addGridField($id);
        
        $crdate = gridField::newGridField();
        $crdate->setField('crdate')->setName('Vytvorené')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_DATETIME);
        $this->addGridField($crdate);
        
        $tstamp = gridField::newGridField();
        $tstamp->setField('tstamp')->setName('Posledná zmena')->setSortable(TRUE)->setType(GRID_FIELD_TYPE_DATETIME);
        $this->addGridField($tstamp);
        
        $this->setGridTableName($this->table_name);
        $this->enableGrid(FALSE);
        $this->enableNewRecord(FALSE);
        $this->enableEditRecord(FALSE);
        $this->enableDeleteRecord(FALSE);
        $this->enablePreviewRecord(FALSE);
    }
    
    private function defaultEditorSettings() {
        $this->editor_settings = array();
    }
}

?>