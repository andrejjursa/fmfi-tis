<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Abstract class for relation between two tables.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

class Abstract_table_relation {
    
    protected $local_table_name = '';
    
    protected $foreign_table_name = '';
    
    protected $rows = NULL;
    
    protected $relation_type_mm = FALSE;
    
    protected $mm_table_name = '';
    
    protected $mm_local_id_field = '';
    
    protected $mm_foreign_id_field = '';
    
    protected $mm_sorting_field = ''; 
    
    protected $foreign_primary_field = 'id';
    
    protected $foreign_index_field = '';
    
    public function __construct() {
        
    }
    
    public function get($local_id, $foreign_ids = NULL) {
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return array();
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        
        if (is_null($this->rows)) {
            $this->rows = array();
            $this->load->database();
            if ($this->relation_type_mm) {
                $this->db->select($this->foreign_table_name . '.*');
                $this->db->from($this->foreign_table_name);
                $this->db->join($this->mm_table_name, $this->foreign_table_name . '.' . $this->foreign_primary_field . ' = ' . $this->mm_table_name . '.' . $this->mm_foreign_id_field);
                $this->db->where($this->mm_table_name . '.' . $this->mm_local_id_field, $real_local_id);
                if ($this->mm_sorting_field != '') {
                    $this->db->order_by($this->mm_table_name . '.' . $this->mm_sorting_field, 'asc');
                }
                $query = $this->db->get();
                
                if ($query->num_rows() > 0) {
                    foreach($query->result_array() as $row) {
                        $object = $this->load->table_row($this->foreign_table_name, $row);
                        if (is_null($object)) { return $this->rows; }
                        $this->rows[] = $object;
                    }
                }
                
                $query->free_result();
            } else {
                if (is_null($foreign_ids)) {
                    $this->db->where($this->foreign_index_field, $real_local_id);
                    $query = $this->db->get($this->foreign_table_name);
                    
                    if ($query->num_rows() > 0) {
                        foreach($query->result_array() as $row) {
                            $object = $this->load->table_row($this->foreign_table_name, $row);
                            if (is_null($object)) { return $this->rows; }
                            $this->rows[] = $object;
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
                        return $this->rows;
                    }
                    
                    for($i=0;$i<count($ids_array);$i++) { $ids_array[$i] = intval($ids_array[$i]); }
                    
                    $this->db->where_in($this->foreign_primary_field, $ids_array);
                    $query = $this->db->get($this->foreign_table_name);
                    
                    if ($query->num_rows() > 0) {
                        foreach($query->result_array() as $row) {
                            $object = $this->load->table_row($this->foreign_table_name, $row);
                            if (is_null($object)) { return $this->rows; }
                            $this->rows[] = $object;
                        }
                    }
                    
                    $query->free_result();
                }
            }
        }
        
        return $this->rows;
    }
    
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
            
            return $this->db->trans_complete();
        }
    }
    
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
            
            return $this->db->trans_complete();
        } else {
            $existence_check->free_result();
            return FALSE;
        }
    }
    
    public function deleteAll($local_id) {
        if (!$this->relation_type_mm) { return FALSE; }
        if (!is_numeric($local_id) && !($local_id instanceof Abstract_table_row)) {
            return FALSE;
        }
        
        $real_local_id = is_numeric($local_id) ? $local_id : $local_id->getId();
        
        $this->load->database();
        
        $this->db->where($this->mm_local_id_field, $real_local_id);
        return $this->db->delete($this->mm_table_name);
    }
    
    public function reset() {
        $this->rows = NULL;
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