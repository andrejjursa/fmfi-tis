<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for relation between two tables.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */

require_once APPPATH . 'core/abstract_table_core.php';

class Abstract_table_relation extends Abstract_table_core {
    
    /**
     * @var string name of foreign table.
     */
    protected $foreign_table_name = '';
    
    /**
     * @var array<Abstract_table_row> array of foreign table rows.
     */ 
    protected $rows = NULL;
    
    /**
     * @var integer count of rows in relation.
     */
    protected $count = NULL;
    
    /**
     * @var array<integer> array of primary index for each row.
     */
    protected $ids = NULL;
    
    /**
     * @var bool switch to mm relation type.
     */
    protected $relation_type_mm = FALSE;
    
    /**
     * @var string name of mm table.
     */
    protected $mm_table_name = '';
    
    /**
     * @var string name of column with local index in mm table.
     */
    protected $mm_local_id_field = '';
    
    /**
     * @var string name of column with foreign index in mm table.
     */
    protected $mm_foreign_id_field = '';
    
    /**
     * @var string name of column with records sorting information in mm table.
     */
    protected $mm_sorting_field = ''; 
    
    /**
     * @var string name of column with primary index in foreign table.
     */
    protected $foreign_primary_field = 'id';
    
    /**
     * @var string name of column with reference index to local table in foreign table.
     */
    protected $foreign_index_field = '';
    
    /**
     *
     * @var string custom order by clausule for selecting.
     */
    protected $custom_order_by = NULL;
    
    /**
     * @var array<integer> custom limit clausule for selecting.
     */
    protected $custom_limit = NULL;
    
    /**
     * @var array<mixed> custom where clausule for selecting.
     */
    protected $custom_where = NULL;
    
    /**
     * This function will set the additional where clausule conditions with optional substituents, it resets the selected rows.
     * 
     * @param string $conditions where clausule conditions as string, can contains question marks for replace with substituens.
     * @param array<mixed> $substituents array of substituents to be replaced against questions marks in where condition, in given order.
     * @return Abstract_table_relation reference to this object.
     */ 
    public function setWhere($conditions = NULL, $substituents = NULL) {
        if (is_null($conditions)) {
            if ($this->custom_where !== NULL) { $this->reset(); }
            $this->custom_where = NULL;
        } elseif (is_string($conditions)) {
            $_substituents = $substituents;
            if (!is_array($substituents)) { $_substituents = NULL; }
            $new_value = array($conditions, $_substituents);
            if (serialize($new_value) != serialize($this->custom_where)) { $this->reset(); }
            $this->custom_where = $new_value;
        }
        return $this;
    }
    
    /**
     * This function will set new limit clausule to select, it resets the selected rows.
     * 
     * @param integer $how_many how many rows to select.
     * @param integer $start_from starting inded.
     * @return Abstract_table_relation reference to this object.
     */
    public function setLimit($how_many = NULL, $start_from = 0) {
        if (is_null($how_many)) {
            if ($this->custom_limit !== NULL) { $this->reset(); }
            $this->custom_limit = NULL;
        } elseif (is_numeric($how_many)) {
            if ($this->custom_limit === NULL || (is_array($this->custom_limit) && ($this->custom_limit[0] != intval($how_many) || $this->custom_limit[1] != intval($start_from)))) {
                $this->reset();    
            }
            $this->custom_limit = array(intval($how_many), intval($start_from));
        }
        return $this;
    }
    
    /**
     * This function will set new ordre by clausule to select, it resets selected rows.
     * 
     * @param string $new_order_by $new_order_by order by clause for select.
     * @return Abstract_table_relation reference to this object.
     */
    public function setOrderBy($new_order_by = NULL) {
        if (is_null($new_order_by) || is_string($new_order_by) && $this->custom_order_by !== $new_order_by) {
            $this->custom_order_by = $new_order_by;
            $this->reset();
        }
        return $this;
    }
    
    /**
     * Returns all foreign rows in relation to list of local ids using.
     * Works only for mm relations.
     * 
     * @param array<integer|Abstract_table_row> $local_ids array of local indexex.
     * @return array<Abstract_table_row> array of foreign rows.
     */
    public function getMultiple($local_ids) {
        if ($this->getRowsAndIdsMultiple($local_ids)) {
            return $this->rows;
        }
        return array();
    }
    
    /**
     * Returns all primary indexes of foreign rows in relation to list of local ids using.
     * Works only for mm relations.
     * 
     * @param array<integer|Abstract_table_row> $local_ids array of local indexex.
     * @return array<integer> array of primary indexes of foreign rows.
     */
    public function allIdsMultiple($local_ids) {
        if ($this->getRowsAndIdsMultiple($local_ids)) {
            return $this->ids;
        }
        return array();
    }
    
    /**
     * Return count of all rows in relation with multiple local rows.
     * Works only for mm relations.
     * 
     * @param array<integer|Abstract_table_row> $local_ids array of local indexes.
     * @return integer count of foreignt rows.
     */
    public function countMultiple($local_ids) {
        if (!is_array($local_ids) || count($local_ids) == 0 || $this->relation_type_mm == FALSE) { return 0; }
        
        if (!is_null($this->count)) { return $this->count; }
        
        $local_ids_array = array();
        
        $this->rows = array();
        $this->ids = array();
        
        foreach ($local_ids as $row_id) {
            if (is_numeric($row_id)) {
                $local_ids_array[] = $row_id;
            } elseif ($row_id instanceof Abstract_table_row && !is_null($row_id->getId())) {
                $local_ids_array[] = $row_id->getId();
            } else {
                return 0;
            }
        }
        
        $this->db->select($this->foreign_table_name . '.*');
        $this->db->from($this->foreign_table_name);
        $this->db->join($this->mm_table_name, $this->foreign_table_name . '.' . $this->foreign_primary_field . ' = ' . $this->mm_table_name . '.' . $this->mm_foreign_id_field);
        $this->db->where_in($this->mm_table_name . '.' . $this->mm_local_id_field, $local_ids_array);
        $this->db->group_by($this->mm_table_name . '.' . $this->mm_foreign_id_field);
        if (!$this->insertOrderByAndNotification($this->db)) {
            if ($this->mm_sorting_field != '') {
                $this->db->order_by($this->mm_table_name . '.' . $this->mm_sorting_field, 'asc');
            }
        }
        $this->count = $this->db->count_all_results();
        
        return $this->count;
    }
    
    /**
     * Returns count of rows in relation.
     * 
     * @param integer|Abstract_table_row $local_id primary index value of local table.
     * @param array<integer|Abstract_table_row> $foreign_ids array of primary index values of foreign table.
     * @return integer count of rows.
     */
    public function count($local_id, $foreign_ids = NULL) {
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return array();
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        
        if (is_null($this->count)) {
            $this->load->database();
            if ($this->relation_type_mm) {
                $this->db->select($this->foreign_table_name . '.*');
                $this->db->from($this->foreign_table_name);
                $this->db->join($this->mm_table_name, $this->foreign_table_name . '.' . $this->foreign_primary_field . ' = ' . $this->mm_table_name . '.' . $this->mm_foreign_id_field);
                $this->db->where($this->mm_table_name . '.' . $this->mm_local_id_field, $real_local_id);
                $this->insertLimit($this->db);
                $this->insertWhere($this->db);
                $this->count = $this->db->count_all_results();
            } else {
                if (is_null($foreign_ids)) {
                    $this->db->where($this->foreign_index_field, $real_local_id);
                    $this->insertLimit($this->db);
                    $this->insertWhere($this->db);
                    $this->count = $this->db->count_all_results($this->foreign_table_name);
                } else {
                    $ids_array = array();
                    if (is_string($foreign_ids) && trim($foreign_ids) != '') {
                        $ids_array = explode(',', $foreign_ids);
                    } else if (is_array($foreign_ids) && count($foreign_ids) > 0) {
                        $ids_array = $foreign_ids;
                    } else if (is_integer($foreign_ids)) {
                        $ids_array = array($foreign_ids);
                    } else {
                        return $this->rows;
                    }
                    
                    for($i=0;$i<count($ids_array);$i++) { $ids_array[$i] = intval($ids_array[$i]); }
                    
                    $this->db->where_in($this->foreign_primary_field, $ids_array);
                    $this->insertLimit($this->db);
                    $this->insertWhere($this->db);
                    $this->count = $this->db->count_all_results($this->foreign_table_name);
                }
            }
        }
        
        return $this->count;
    }
    
    /**
     * Renew array of foreign table rows if it is NULL and returns it.
     * 
     * @param integer|Abstract_table_row $local_id primary index value of local table.
     * @param array<integer|Abstract_table_row> $foreign_ids array of primary index values of foreign table.
     * @return array<Abstract_table_row> array of foreign table rows.
     */
    public function get($local_id, $foreign_ids = NULL) {
        $this->getRowsAndIds($local_id, $foreign_ids);
        
        return $this->rows;
    }
    
    /**
     * Renew array of foreign table primary indexes if it is NULL and returns it.
     * 
     * @param integer|Abstract_table_row $local_id primary index value of local table.
     * @param array<integer|Abstract_table_row> $foreign_ids array of primary index values of foreign table.
     * @return array<Abstract_table_row> array of foreign table primary indexes.
     */
    public function allIds($local_id, $foreign_ids = NULL) {
        $this->getRowsAndIds($local_id, $foreign_ids);
        
        return $this->ids;
    }
    
    /**
     * This function will add new relation to mm table.
     * Optionaly can be sorted.
     * 
     * Returns FALSE if relation already exists.
     * 
     * @param integer|Abstract_table_row $local_id local table primary key value.
     * @param integer|Abstract_table_row $foreign_id foreign table primary key value.
     * @param integer|Abstract_table_row $after_id foreign table primary key value, which has to be before new inserted record in sorting order.
     * @return bool TRUE, when record is inserted, FALSE otherwise.
     */
    public function add($local_id, $foreign_id, $after_id = NULL) {
        if (!$this->relation_type_mm) { return FALSE; }
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        if (!is_numeric($foreign_id) && !($foreign_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        if (!is_null($after_id) && !is_numeric($after_id) && !($after_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        $real_foreign_id = is_numeric($foreign_id) ? $foreign_id : $foreign_id->getId();
        $real_after_id = is_null($after_id) ? NULL : (is_numeric($after_id) ? $after_id : $after_id->getId());
        
        if (is_null($real_foreign_id) || is_null($real_local_id)) { return FALSE; }
        
        $this->load->database();
        
        $this->db->where($this->mm_local_id_field, $real_local_id);
        $this->db->where($this->mm_foreign_id_field, $real_foreign_id);
        $existence_query = $this->db->get($this->mm_table_name);
        
        if ($existence_query->num_rows() == 1) {
            $existence_query->free_result();
            return FALSE;
        } else {
            $existence_query->free_result();
            
            $this->db->trans_start();
            
            if ($this->mm_sorting_field != '') {
                if (is_null($real_after_id)) {
                    $this->db->select_max($this->mm_sorting_field, 'sorting');
                    $this->db->where($this->mm_local_id_field, $real_local_id);
                    $last_sort_value_query = $this->db->get($this->mm_table_name);
                    $new_sorting = $last_sort_value_query->row()->sorting;
                    $last_sort_value_query->free_result();
                    
                    $this->db->set($this->mm_sorting_field, $new_sorting + 1);
                } else {
                    $this->db->select_min($this->mm_sorting_field, 'sorting');
                    $this->db->where($this->mm_local_id_field, $real_local_id);
                    $this->db->where($this->mm_foreign_id_field, $real_after_id);
                    $after_sort_value_query = $this->db->get($this->mm_table_name);
                    $new_sorting = intval($after_sort_value_query->row()->sorting);
                    $after_sort_value_query->free_result();
                    
                    $this->db->set($this->mm_sorting_field, $this->db->protect_identifiers($this->mm_sorting_field) . ' + 1', FALSE);
                    $this->db->where($this->mm_sorting_field . ' > ', $new_sorting);
                    $this->db->where($this->mm_local_id_field, $real_local_id);
                    $this->db->update($this->mm_table_name);
                    
                    $this->db->set($this->mm_sorting_field, $new_sorting + 1);
                }
            }
            
            $this->db->set($this->mm_local_id_field, $real_local_id);
            $this->db->set($this->mm_foreign_id_field, $real_foreign_id);
            $this->db->insert($this->mm_table_name);
            
            $this->reset();
            
            return $this->db->trans_complete();
        }
    }
    
    /**
     * Deletes relation from mm table.
     * 
     * @param integer|Abstract_table_row $local_id local table primary key value.
     * @param integer|Abstract_table_row $foreign_id foreign table primary key value.
     * @return bool TRUE, when this relation is deleted, FALSE otherwise.
     */
    public function delete($local_id, $foreign_id) {
        if (!$this->relation_type_mm) { return FALSE; }
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        if (!is_numeric($foreign_id) && !($foreign_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        $real_foreign_id = is_numeric($foreign_id) ? $foreign_id : $foreign_id->getId();
        
        $this->load->database();
        
        $this->db->where($this->mm_local_id_field, $real_local_id);
        $this->db->where($this->mm_foreign_id_field, $real_foreign_id);
        $existence_check = $this->db->get($this->mm_table_name);
        
        if ($existence_check->num_rows() == 1) {
            $existence_check->free_result();
            
            $this->db->trans_start();
            
            if ($this->mm_sorting_field != '') {
                $this->db->select_max($this->mm_sorting_field, 'sorting');
                $this->db->where($this->mm_local_id_field, $real_local_id);
                $this->db->where($this->mm_foreign_id_field, $real_foreign_id);
                $my_sorting_number_query = $this->db->get($this->mm_table_name);
                $my_sorting_number = $my_sorting_number_query->row()->sorting;
                $my_sorting_number_query->free_result();
                
                $this->db->set($this->mm_sorting_field, $this->db->protect_identifiers($this->mm_sorting_field) . ' - 1', FALSE);
                $this->db->where($this->mm_sorting_field . ' > ', $my_sorting_number);
                $this->db->where($this->mm_local_id_field, $real_local_id);
                $this->db->update($this->mm_table_name);
            }
            
            $this->db->where($this->mm_local_id_field, $real_local_id);
            $this->db->where($this->mm_foreign_id_field, $real_foreign_id);
            $this->db->delete($this->mm_table_name);
            
            $this->reset();
            
            return $this->db->trans_complete();
        } else {
            $existence_check->free_result();
            return FALSE;
        }
    }
    
    /**
     * This function will delete all existing relations and add new relations between local table row and array of foreign table rows.
     * 
     * @param integer|Abstract_table_row $local_id local table primary key value.
     * @param array<integer|Abstract_table_row> $foreign_ids array of foreign table primary key values.
     * @return bool TRUE, when new relations are established, FALSE otherwise.
     */
    public function setTo($local_id, $foreign_ids) {
        if (!$this->relation_type_mm) { return FALSE; }
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        if (!is_array($foreign_ids)) { return FALSE; }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        
        $this->load->database();
        
        $insert_data = array();
        
        if (count($foreign_ids) > 0) {
            $sorting = 1;
            foreach($foreign_ids as $foreign_id) {
                if (!is_numeric($foreign_id) && !($foreign_id instanceof Abstract_table_row)) {
                    return FALSE;
                }
                $real_foreign_id = is_numeric($foreign_id) ? $foreign_id : $foreign_id->getId();
                
                $row = array(
                    $this->mm_local_id_field => $real_local_id,
                    $this->mm_foreign_id_field => $real_foreign_id,
                );
                
                if ($this->mm_sorting_field != '') {
                    $row[$this->mm_sorting_field] = $sorting;
                }
                
                $insert_data[] = $row;
                
                $sorting++;
            }
        }
        
        $this->db->trans_start();
        
        $this->deleteAll($real_local_id);
        
        if (count($insert_data) > 0) {
            $this->db->insert_batch($this->mm_table_name, $insert_data);
        }
        
        $this->reset();
        
        return $this->db->trans_complete();
    }
    
    /**
     * Deletes all relations between local and foreign tables from database mm table.
     * 
     * @param integer|Abstact_table_row $local_id id of local table, from which have to be deleted all relations to foreign table.
     * @return bool TRUE, if all relations are deleted, FALSE otherwise.
     */
    public function deleteAll($local_id) {
        if (!$this->relation_type_mm) { return FALSE; }
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        
        $this->reset();
        
        $this->load->database();
        
        $this->db->where($this->mm_local_id_field, $real_local_id);
        return $this->db->delete($this->mm_table_name);
    }
    
    /**
     * Empty rows array and set them to NULL, so it will be refilled after calling get() method.
     * 
     * @return void
     */
    public function reset() {
        $this->rows = NULL;
        $this->count = NULL;
        $this->ids = NULL;
    }
    
    /**
     * Query database for related foreign table rows and theirs primary indexes.
     * 
     * @param integer|Abstract_table_row $local_id primary index value of local table.
     * @param array<integer|Abstract_table_row> $foreign_ids array of primary index values of foreign table.
     */
    protected function getRowsAndIds($local_id, $foreign_ids = NULL) {
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return;
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        
        if (is_null($this->rows) || is_null($this->ids)) {
            $this->rows = array();
            $this->ids = array();
            $this->load->database();
            if ($this->relation_type_mm) {
                $this->db->select($this->foreign_table_name . '.*');
                $this->db->from($this->foreign_table_name);
                $this->db->join($this->mm_table_name, $this->foreign_table_name . '.' . $this->foreign_primary_field . ' = ' . $this->mm_table_name . '.' . $this->mm_foreign_id_field);
                $this->db->where($this->mm_table_name . '.' . $this->mm_local_id_field, $real_local_id);
                if (!$this->insertOrderByAndNotification($this->db)) {
                    if ($this->mm_sorting_field != '') {
                        $this->db->order_by($this->mm_table_name . '.' . $this->mm_sorting_field, 'asc');
                    }
                }
                $this->insertLimit($this->db);
                $this->insertWhere($this->db);
                $query = $this->db->get();
                
                if ($query->num_rows() > 0) {
                    foreach($query->result_array() as $row) {
                        $object = $this->load->table_row($this->foreign_table_name, $row);
                        if (is_null($object)) { return; }
                        $this->rows[] = $object;
                        $this->ids[] = $object->getId();
                    }
                }
                
                $query->free_result();
            } else {
                if (is_null($foreign_ids)) {
                    $this->db->where($this->foreign_index_field, $real_local_id);
                    $this->insertOrderByAndNotification($this->db);
                    $this->insertLimit($this->db);
                    $this->insertWhere($this->db);
                    $query = $this->db->get($this->foreign_table_name);
                    
                    if ($query->num_rows() > 0) {
                        foreach($query->result_array() as $row) {
                            $object = $this->load->table_row($this->foreign_table_name, $row);
                            if (is_null($object)) { return; }
                            $this->rows[] = $object;
                            $this->ids[] = $object->getId();
                        }
                    }
                    
                    $query->free_result();
                } else {
                    $ids_array = array();
                    if (is_string($foreign_ids) && trim($foreign_ids) != '') {
                        $ids_array = explode(',', $foreign_ids);
                    } else if (is_array($foreign_ids) && count($foreign_ids) > 0) {
                        $ids_array = $foreign_ids;
                    } else if (is_integer($foreign_ids)) {
                        $ids_array = array($foreign_ids);
                    } else {
                        return;
                    }
                    
                    for($i=0;$i<count($ids_array);$i++) { $ids_array[$i] = intval($ids_array[$i]); }
                    
                    $this->db->where_in($this->foreign_primary_field, $ids_array);
                    $this->insertOrderByAndNotification($this->db);
                    $this->insertLimit($this->db);
                    $this->insertWhere($this->db);
                    $query = $this->db->get($this->foreign_table_name);
                    
                    if ($query->num_rows() > 0) {
                        foreach($query->result_array() as $row) {
                            $object = $this->load->table_row($this->foreign_table_name, $row);
                            if (is_null($object)) { return; }
                            $this->rows[] = $object;
                            $this->ids[] = $object->getId();
                        }
                    }
                    
                    $query->free_result();
                }
            }
        }
    }
    
    /**
     * Loads foreign table rows related to list of local ids, only works for mm relations.
     * 
     * @param array<integer|Abstract_table_row> $local_ids array of local indexes.
     * @return boolean TRUE, if everything is ok and query were executed, FALSE otherwise.
     */ 
    protected function getRowsAndIdsMultiple($local_ids) {
        if (!is_array($local_ids) || count($local_ids) == 0 || $this->relation_type_mm == FALSE) { return FALSE; }
        
        if (!is_null($this->rows) && !is_null($this->ids)) { return TRUE; }
        
        $local_ids_array = array();
        
        $this->rows = array();
        $this->ids = array();
        
        foreach ($local_ids as $row_id) {
            if (is_numeric($row_id)) {
                $local_ids_array[] = $row_id;
            } elseif ($row_id instanceof Abstract_table_row && !is_null($row_id->getId())) {
                $local_ids_array[] = $row_id->getId();
            } else {
                return FALSE;
            }
        }
        
        $this->db->select($this->foreign_table_name . '.*');
        $this->db->from($this->foreign_table_name);
        $this->db->join($this->mm_table_name, $this->foreign_table_name . '.' . $this->foreign_primary_field . ' = ' . $this->mm_table_name . '.' . $this->mm_foreign_id_field);
        $this->db->where_in($this->mm_table_name . '.' . $this->mm_local_id_field, $local_ids_array);
        $this->db->group_by($this->mm_table_name . '.' . $this->mm_foreign_id_field);
        if (!$this->insertOrderByAndNotification($this->db)) {
            if ($this->mm_sorting_field != '') {
                $this->db->order_by($this->mm_table_name . '.' . $this->mm_sorting_field, 'asc');
            }
        }
        $this->insertLimit($this->db);
        $this->insertWhere($this->db);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            foreach($query->result_array() as $row) {
                $object = $this->load->table_row($this->foreign_table_name, $row);
                if (is_null($object)) { return FALSE; }
                $this->rows[] = $object;
                $this->ids[] = $object->getId();
            }
        }
        
        $query->free_result();
        
        return TRUE;
    }
    
    /**
     * Inserts custom ORDER BY clausule to given active record and return boolean notification.
     * 
     * @param CI_DB_active_record $db database active record object.
     * @return boolean TRUE, if there is custom order by clause, or FALSE otherwise.
     */
    private function insertOrderByAndNotification(CI_DB_active_record $db) {
        if (is_string($this->custom_order_by) && !empty($this->custom_order_by)) {
            if ($this->custom_order_by == 'random') {
                $db->order_by(NULL, 'random');
            } else {
                $db->order_by($this->custom_order_by);
            }
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Inserts custom LIMIT clausule to given active record.
     * 
     * @param CI_DB_active_record $db database active record object.
     * @return void
     */
    private function insertLimit(CI_DB_active_record $db) {
        if (is_array($this->custom_limit) && count($this->custom_limit) == 2) {
            $db->limit($this->custom_limit[0], $this->custom_limit[1]);
        }
    }
    
    /**
     * Inserts custom additional condition(s) to WHERE clausule in given active record.
     * 
     * @param CI_DB_active_record $db database active record object.
     * @return void
     */
    private function insertWhere(CI_DB_active_record $db) {
        if (is_array($this->custom_where) && count($this->custom_where) == 2) {
            $where = $this->custom_where[0];
            if (is_array($this->custom_where[1]) && count($this->custom_where[1])) {
                foreach ($this->custom_where[1] as $value) {
                    $where = $this->replaceFirstQuestionMark($where, $value, $db);
                }
            }
            $db->where($where);
        }
    }
    
    /**
     * Replaces first found question mark with given value using given database active record class.
     * 
     * @param string $where where clausule to be altered.
     * @param mixed $value value, to be replacet against first question mark from left.
     * @param CI_DB_active_record $db database active record object.
     * @return string altered where clausule.
     */
    private function replaceFirstQuestionMark($where, $value, CI_DB_active_record $db) {
        $escaped_value = $db->escape($value);
        $index = strpos($where, '?', 0);
        if ($index !== FALSE) {
            return substr($where, 0, $index) . $escaped_value . substr($where, $index + 1);
        }
        return $where;
    }
}

?>