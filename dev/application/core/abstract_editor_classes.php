<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

define('GRID_FIELD_TYPE_TEXT', 'text');
define('GRID_FIELD_TYPE_DATETIME', 'datetime');
define('GRID_FIELD_TYPE_HTML', 'html');
define('GRID_FIELD_TYPE_IMAGE', 'image');
define('GRID_FIELD_TYPE_FILE', 'file');
define('GRID_FIELD_TYPE_NUMBER', 'number');
define('GRID_FIELD_TYPE_BOOL', 'bool');

define('EDITOR_FIELD_TYPE_TEXT', 'text');
define('EDITOR_FIELD_TYPE_DATETIME', 'datetime');
define('EDITOR_FIELD_TYPE_HTML', 'html');
define('EDITOR_FIELD_TYPE_SELECT', 'select');
define('EDITOR_FIELD_TYPE_FILE', 'file');
define('EDITOR_FIELD_TYPE_BOOL', 'bool');

class gridField {
    
    private $field = 'id';
    
    private $name = 'Index';
    
    private $sortable = TRUE;
    
    private $type = GRID_FIELD_TYPE_TEXT;
    
    private $sub_field = NULL;
    
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
    
    public function setSubField($sub_field) {
        if (is_object($sub_field) && $sub_field instanceof gridField) {
            $this->sub_field = $sub_field;
        } else {
            throw new exception('gridField::setSubField argument must be instance of gridField class');
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
    
    public function getSubField() {
        return $this->sub_field;
    }
}

class editorTab {
    
    private $tab_name = '';
    
    private $tab_fields = array();
    
    public static function getNewEditorTab() {
        return new editorTab();
    }
    
    public function setName($name = '') {
        if (is_string($name)) {
            $this->tab_name = $name;
        } else {
            throw new exception('editorTab::setName argument must be string');
        }
        return $this;
    }
    
    public function addField($field = NULL) {
        if (is_object($field) && $field instanceof editorField) {
            $this->tab_fields[] = $field;
        } else {
            throw new exception('editorTab::addField argument must be instance of editorField class');
        }
        return $this;
    }
    
    public function getName() {
        return $this->tab_name;
    }
    
    public function getFields() {
        return $this->tab_fields;
    }
    
}

abstract class editorField {
    
    private $field = '';
    
    private $field_label = '';
    
    private $field_hint = '';
    
    private $rules = array();
    
    public function setField($field) {
        if (is_string($field)) {
            $this->field = $field;
        } else {
            throw new exception(get_class($this) . '::setField argument must be string');
        }
        return $this;
    }
    
    public function setFieldLabel($field_label) {
        if (is_string($field_label)) {
            $this->field_label = $field_label;
        } else {
            throw new exception(get_class($this) . '::setFieldLabel argument must be string');
        }
        return $this;
    }
    
    public function setFieldHint($field_hint) {
        if (is_string($field_hint)) {
            $this->field_hint = $field_hint;
        } else {
            throw new exception(get_class($this) . '::setFieldHint argument must be string');
        }
        return $this;
    }
    
    public function setRules($rules) {
        if (is_array($rules)) {
            $this->rules = $rules;
        } else {
            throw new exception(get_class($this) . '::setRules argument must be array');
        }
        return $this;
    }
    
    public function getField() {
        return $this->field;
    }
    
    public function getFieldLabel() {
        return $this->field_label;
    }
    
    public function getFieldHint() {
        return $this->field_hint;
    }
    
    public function getRules() {
        return $this->rules;
    }
    
    public function getRulesJSON() {
        return json_encode($this->rules, JSON_FORCE_OBJECT);
    }
    
    abstract public function getFieldType();
    
    abstract public function getFieldHtmlID();
    
}

class editorFieldText extends editorField {
    
    public function getFieldType() {
        return 'text_field';
    }
    
    public function getFieldHtmlID() {
        return 'text_field_' . $this->getField() . '_id';
    }
    
}

class editorFieldSingleCheckbox extends editorField {
    
    private $default = FALSE;
    
    private $checkbox_text = '';
    
    private $value = '';
    
    public function getFieldType() {
        return 'single_checkbox';
    }
    
    public function setDefaultChecked($default) {
        if (is_bool($default)) {
            $this->default = $default;
        } else {
            throw new exception(get_class($this) . '::setDefaultChecked argument must be boolean');
        }
        return $this;
    }
    
    public function setCheckboxText($text) {
        if (is_string($text)) {
            $this->checkbox_text = $text;
        } else {
            throw new exception(get_class($this) . '::setCheckboxText argument must be string');
        }
        return $this;
    }
    
    public function setDefaultValue($value) {
        if (is_bool($value) || is_string($value) || is_numeric($value)) {
            $this->value = $value;
        } else {
            throw new exception(get_class($this) . '::setDefaultValue argument must be string, boolean or number');
        }
        return $this;
    }
    
    public function getDefaultChecked() {
        return $this->default;
    }
    
    public function getCheckboxText() {
        return $this->checkbox_text;
    }
    
    public function getDefaultValue() {
        return $this->value;
    }
    
    public function getFieldHtmlID() {
        return 'single_checkbox_field_' . $this->getField() . '_id';
    }
    
}

?>