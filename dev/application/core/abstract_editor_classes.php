<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('GRID_FIELD_TYPE_TEXT', 'text');
define('GRID_FIELD_TYPE_DATETIME', 'datetime');
define('GRID_FIELD_TYPE_HTML', 'html');

class gridField {
    
    private $field = 'id';
    
    private $name = 'Index';
    
    private $sortable = TRUE;
    
    private $type = GRID_FIELD_TYPE_TEXT;
    
    /**
     * Creates new instance of this class.
     * 
     * @return gridField instance of gridField class.
     */ 
    public static function newGridField() {
        return new gridField();
    }
    
    public function setField($field) {
        if (is_string($field)) {
            $this->field = $field;
        } else {
            throw new exception('gridField::setField argument must be string');
        }
        
        return $this;
    }
    
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        } else {
            throw new exception('gridField::setName argument must be string');
        }
        
        return $this;
    }
    
    public function setSortable($sortable) {
        if (is_bool($sortable)) {
            $this->sortable = $sortable;
        } else {
            throw new exception('gridField::setSortable argument must be bool');
        }
        
        return $this;
    }
    
    public function setType($type) {
        if (is_string($type)) {
            $this->type = $type;
        } else {
            throw new exception('gridField::setType argument must be string');
        }
        
        return $this;
    }
    
    public function getField() {
        return $this->field;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getSortable() {
        return $this->sortable;
    }
    
    public function getType() {
        return $this->type;
    }
}

?>