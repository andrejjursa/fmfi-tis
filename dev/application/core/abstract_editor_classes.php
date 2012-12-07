<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classes for admin editor decorator.
 * 
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * @package Abstract
 * @subpackage Core
 * 
 */

define('GRID_FIELD_TYPE_TEXT', 'text');
define('GRID_FIELD_TYPE_DATETIME', 'datetime');
define('GRID_FIELD_TYPE_HTML', 'html');
define('GRID_FIELD_TYPE_IMAGE', 'image');
define('GRID_FIELD_TYPE_FILE', 'file');
define('GRID_FIELD_TYPE_NUMBER', 'number');
define('GRID_FIELD_TYPE_BOOL', 'bool');
define('GRID_FIELD_TYPE_SMARTY', 'smarty');

/**
 * Grid field class, which is responsible for configuration of single table column design in editor grid view.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class gridField {
    
    /**
     * @var string name of field in table.
     */
    private $field = 'id';
    
    /**
     * @var string name of table column.
     */
    private $name = 'Index';
    
    /**
     * @var boolean sortable flag for column defined by this object.
     */
    private $sortable = TRUE;
    
    /**
     * @var boolean type of table column, can be one of GRID_FIELD_TYPE_*.
     */
    private $type = GRID_FIELD_TYPE_TEXT;
    
    /**
     * @var gridField subfield or NULL.
     */
    private $sub_field = NULL;
    
    /**
     * @var string width information for table column styling.
     */
    private $width = 'auto';
    
    /**
     * @var string inline smarty template code.
     */
    private $smarty = '';
    
    /**
     * Creates new instance of this class.
     * 
     * @return gridField instance of gridField class.
     */ 
    public static function newGridField() {
        return new gridField();
    }
    
    /**
     * Set the table column field.
     * 
     * @param string $field name of field in talbe.
     * @return gridField reference to this object.
     */
    public function setField($field) {
        if (is_string($field)) {
            $this->field = $field;
        } else {
            throw new exception('gridField::setField argument must be string');
        }
        
        return $this;
    }
    
    /**
     * Set the table column name.
     * 
     * @param string $name name of table column in table header.
     * @return gridField reference to this object.
     */
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        } else {
            throw new exception('gridField::setName argument must be string');
        }
        
        return $this;
    }
    
    /**
     * Set the sortable flag for this table column.
     * 
     * @param boolean $sortable TRUE for sortable, FALSE otherwise.
     * @return gridField reference to this object.
     */
    public function setSortable($sortable) {
        if (is_bool($sortable)) {
            $this->sortable = $sortable;
        } else {
            throw new exception('gridField::setSortable argument must be bool');
        }
        
        return $this;
    }
    
    /**
     * Set the content type for this table column.
     * 
     * @param string $type type of content, usualy one of GRID_FIELD_TYPE_* constant.
     * @return gridField reference to this object.
     */
    public function setType($type) {
        if (is_string($type)) {
            $this->type = $type;
        } else {
            throw new exception('gridField::setType argument must be string');
        }
        
        return $this;
    }
    
    /**
     * Set the subfield for this field (ie: for image rendering).
     * 
     * @param gridField $sub_field sub field.
     * @return gridField reference to this object.
     */
    public function setSubField($sub_field) {
        if (is_object($sub_field) && $sub_field instanceof gridField) {
            $this->sub_field = $sub_field;
        } else {
            throw new exception('gridField::setSubField argument must be instance of gridField class');
        }
        
        return $this;
    }
    
    /**
     * Set the width information for style tag, which set the width of this table column.
     * 
     * @param string $width width of table column.
     * @return gridField reference to this object.
     */
    public function setWidth($width) {
        if (is_string($width)) {
            $this->width = $width;
        } else {
            throw new exception('gridField::setWidth argument must be string');
        }
        
        return $this;
    }
    
    /**
     * Set inline template code for smarty parser (ie: used for type GRID_FIELD_TYPE_SMARTY).
     * 
     * @param string $smarty inline template code.
     * @return gridField reference to this object.
     */
    public function setSmarty($smarty) {
        if (is_string($smarty)) {
            $this->smarty = $smarty;
        } else {
            throw new exception('gridField::setSmarty argument must be string');
        }
        
        return $this;
    }
    
    /**
     * Returns table field.
     * 
     * @return string table field in sql table.
     */
    public function getField() {
        return $this->field;
    }
    
    /**
     * Returns header name for table column in grid view.
     * 
     * @return string name of table column.
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Returns sortable flag.
     * 
     * @return boolean sortable flag.
     */
    public function getSortable() {
        return $this->sortable;
    }
    
    /**
     * Returns type of field.
     * 
     * @return string type of field.
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * Returns sub field.
     * 
     * @return gridField sub field or NULL.
     */
    public function getSubField() {
        return $this->sub_field;
    }
    
    /**
     * Returns table column width.
     * 
     * @return string table column width.
     */
    public function getWidth() {
        return $this->width;
    }
    
    /**
     * Returns parsed smarty inline template. Takes one argument, which is smarty interpreter.
     * 
     * @param Smarty_internal_template $smarty smarty internal template interpreter class.
     * @return string parsed inline smarty template.
     */
    public function getSmarty(Smarty_internal_template $smarty) {
        $CI =& get_instance();
        $CI->load->library('parser');
        $data = $smarty->getTemplateVars();
        return $CI->parser->parse_string($this->smarty, $data);
    }
}

/**
 * Editor tab for editor form. Used for logical separation of form elements.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorTab {
    
    /**
     * @var string name (or title) of tab in rendered editor form.
     */
    private $tab_name = '';
    
    /**
     * @var array<editorField> list of fields in this tab.
     */
    private $tab_fields = array();
    
    /**
     * Returns new instance of editorTab.
     * 
     * @return editorTab new instance.
     */
    public static function getNewEditorTab() {
        return new editorTab();
    }
    
    /**
     * Set the name (or title) of tab in rendered editor form.
     * 
     * @param string $name name of field.
     * @return editorTab reference to this object.
     */
    public function setName($name = '') {
        if (is_string($name)) {
            $this->tab_name = $name;
        } else {
            throw new exception('editorTab::setName argument must be string');
        }
        return $this;
    }
    
    /**
     * Add field to this tab. If field already exists in tab, it will overwrite that field.
     * 
     * @param editorField $field editor form field.
     * @return editorTab reference to this object.
     */
    public function addField($field = NULL) {
        if (is_object($field) && $field instanceof editorField) {
            $this->tab_fields[$field->getField()] = $field;
        } else {
            throw new exception('editorTab::addField argument must be instance of editorField class');
        }
        return $this;
    }
    
    /**
     * Returns name (or title) of this tab.
     * 
     * @return string tab name.
     */
    public function getName() {
        return $this->tab_name;
    }
    
    /**
     * Returns list of all fields in this tab.
     * 
     * @return array<editorField> list of all fields.
     */
    public function getFields() {
        return $this->tab_fields;
    }
    
}

/**
 * Abstract editor field class.
 * 
 * @abstract this is base class, need to be extended for use.
 * @author Andrej Jursa
 * @version 1.0
 */
abstract class editorField {
    
    /**
     * @var string sql table field name.
     */
    private $field = '';
    
    /**
     * @var string in editor field label.
     */
    private $field_label = '';
    
    /**
     * @var string in editor field tooltip (on label).
     */
    private $field_hint = '';
    
    /**
     * @var array<mixed> array of validation rules for this editor field.
     */
    private $rules = array();
    
    /**
     * Set the sql table field name.
     * 
     * @param string $field name of column in sql table or table row getter (without get prefix).
     * @return editorField reference to this object.
     */
    public function setField($field) {
        if (is_string($field)) {
            $this->field = $field;
        } else {
            throw new exception(get_class($this) . '::setField argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the label for this field in editor form.
     * 
     * @param string $field_label label text in editor form.
     * @return editorField reference to this object.
     */
    public function setFieldLabel($field_label) {
        if (is_string($field_label)) {
            $this->field_label = $field_label;
        } else {
            throw new exception(get_class($this) . '::setFieldLabel argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the field hint, or tooltip, displayed on field label in editor form.
     * 
     * @param string $field_hint hint text for editor field.
     * @return editorField reference to this object.
     */
    public function setFieldHint($field_hint) {
        if (is_string($field_hint)) {
            $this->field_hint = $field_hint;
        } else {
            throw new exception(get_class($this) . '::setFieldHint argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the associative array of rules for form validation based up on jquery validation plugin.
     * 
     * @param array<mixed> $rules validation rules for this field.
     * @return editorField reference to this object.
     */
    public function setRules($rules) {
        if (is_array($rules)) {
            $this->rules = $rules;
        } else {
            throw new exception(get_class($this) . '::setRules argument must be array');
        }
        return $this;
    }
    
    /**
     * Returns the sql table field name of table row getter without get prefix.
     *
     * @return string field.
     */
    public function getField() {
        return $this->field;
    }
    
    /**
     * Returns the label text for this field.
     * 
     * @return string label text.
     */
    public function getFieldLabel() {
        return $this->field_label;
    }
    
    /**
     * Returns the label hint text for this field.
     * 
     * @return string label hint text.
     */
    public function getFieldHint() {
        return $this->field_hint;
    }
    
    /**
     * Returns the original array of validation rules.
     * 
     * @return array<mixed> array of validation rules.
     */
    public function getRules() {
        return $this->rules;
    }
    
    /**
     * Returns the JSON version of validation rules, enforced all to be objects.
     * 
     * @return string JSON version of validation rules.
     */
    public function getRulesJSON() {
        return json_encode($this->rules, JSON_FORCE_OBJECT);
    }
    
    /**
     * Returns field type.
     * 
     * @abstract need to be implemented in derived class.
     * @return string field type.
     */
    abstract public function getFieldType();
    
    /**
     * Returns field id in editor form.
     * 
     * @abstract need to be implemented in derived class.
     * @return string field id in editor form.
     */
    abstract public function getFieldHtmlID();
    
}

/**
 * Editor field for simple text input.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldText extends editorField {
    
    /**
     * @var string default text in editor form input element.
     */
    private $default_text = '';
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'text_field';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'text_field_' . $this->getField() . '_id';
    }
    
    /**
     * Set the default text in editor form input element.
     * 
     * @param string $default default text.
     * @return editorFieldText reference to this object.
     */
    public function setDefaultText($default) {
        if (is_string($default)) {
            $this->default_text = $default;
        } else {
            throw new exception(get_class($this) . '::setDefaultText argument must be string');
        }
        return $this;
    }
    
    /**
     * Returns default text.
     * 
     * @return string default text for input element.
     */
    public function getDefaultText() {
        return $this->default_text;
    }
    
}

/**
 * Editor field for TinyMCE editor for html code.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldTinymce extends editorField {
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'tinymce_field';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'tinymce_field_' . $this->getField() . '_id';
    }
    
}

/**
 * Editor field for single checkbox.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldSingleCheckbox extends editorField {
    
    /**
     * @var boolean flag for checkbox to be or not to be checked by default.
     */
    private $default = FALSE;
    
    /**
     * @var string optional text for label before checkbox in editor form.
     */
    private $checkbox_text = '';
    
    /**
     * @var string|boolean|numeric value of checkbox.
     */
    private $value = '';
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'single_checkbox';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'single_checkbox_field_' . $this->getField() . '_id';
    }
    
    /**
     * Set the state of checkbox to be or not to be checked by default.
     * 
     * @param boolean $default the state.
     * @return editorFieldSingleCheckbox reference to this object.
     */
    public function setDefaultChecked($default) {
        if (is_bool($default)) {
            $this->default = $default;
        } else {
            throw new exception(get_class($this) . '::setDefaultChecked argument must be boolean');
        }
        return $this;
    }
    
    /**
     * Set optional label text.
     * 
     * @param string $text optional label text.
     * @return editorFieldSingleCheckbox reference to this object.
     */
    public function setCheckboxText($text) {
        if (is_string($text)) {
            $this->checkbox_text = $text;
        } else {
            throw new exception(get_class($this) . '::setCheckboxText argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the value of checkbox.
     * 
     * @param string|boolean|numeric $value value of checkbox.
     * @return editorFieldSingleCheckbox reference to this object.
     */
    public function setDefaultValue($value) {
        if (is_bool($value) || is_string($value) || is_numeric($value)) {
            $this->value = $value;
        } else {
            throw new exception(get_class($this) . '::setDefaultValue argument must be string, boolean or number');
        }
        return $this;
    }
    
    /**
     * Returns default checked flag.
     * 
     * @return boolean default checked state.
     */
    public function getDefaultChecked() {
        return $this->default;
    }
    
    /**
     * Returns optional label text.
     * 
     * @return string optional label text.
     */
    public function getCheckboxText() {
        return $this->checkbox_text;
    }
    
    /**
     * Returns value of checkbox.
     * 
     * @return string|boolean|numeric value of checkbox.
     */
    public function getDefaultValue() {
        return $this->value;
    }
    
}

/**
 * Editor field for Uploadify file uploader.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldFileUpload extends editorField {
    
    /**
     * @var string upload path for files.
     */
    private $upload_path = '';
    
    /**
     * @var string semicolon separated list of allowed file types (list of extensions, as: *.extension).
     */
    private $allowed_types = '*.*';
    
    /**
     * @var string|integer maximum size of file to be uploaded.
     */
    private $max_size = '2MB';
    
    /**
     * @var boolean fancybox flag, for images upload.
     */
    private $use_fancybox = false;
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'file_upload_field';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'file_upload_field_' . $this->getField() . '_id';
    }
    
    /**
     * Set the upload path for the file.
     * 
     * @param string $path upload path.
     * @return editorFieldFileUpload reference to this object.
     */
    public function setUploadPath($path) {
        if (is_string($path)) {
            if (substr(ltrim($path, '/'), 0, 14) == 'public/uploads') {
                $this->upload_path = $path;    
            } else {
                throw new exception(get_class($this) . '::setUploadPath argument value must begin with public/uploads');
            }
        } else {
            throw new exception(get_class($this) . '::setUploadPath argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the allowed file types.
     * 
     * @param string $types allowed file types.
     * @return editorFieldFileUpload reference to this object.
     */
    public function setAllowedTypes($types) {
        if (is_string($types)) {
            $this->allowed_types = $types;
        } else {
            throw new exception(get_class($this) . '::setAllowedTypes argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the maximum allowed file size.
     * 
     * @param string|integer $size maximum size of file.
     * @return editorFieldFileUpload reference to this object.
     */
    public function setMaxSize($size) {
        if (is_string($size) || is_integer($size)) {
            $this->max_size = $size;
        } else {
            throw new exception(get_class($this) . '::setMaxSize argument must be string or integer');
        }
        return $this;
    }
    
    /**
     * Set fancybox flag for image uploads.
     * 
     * @param boolean $state TRUE for use of fancybox for images instead of download them.
     * @return editorFieldFileUpload reference to this object.
     */
    public function setUseFancybox($state) {
        if (is_bool($state)) {
            $this->use_fancybox = $state;
        } else{
            throw new exception(get_class($this) . '::setUseFancybox argument must be boolean');
        }
        return $this;
    }
    
    /**
     * Returns file upload path.
     * 
     * @return string file upload path.
     */
    public function getUploadPath() {
        return $this->upload_path;
    }
    
    /**
     * Returns allowed file types.
     * 
     * @return string allowed file types.
     */
    public function getAllowedTypes() {
        return $this->allowed_types;
    }
    
    /**
     * Returns maximum file size.
     * 
     * @return string|integer maximum file size.
     */
    public function getMaxSize() {
        return $this->max_size;
    }
    
    /**
     * Returns fancybox flag.
     * 
     * @return boolean fancybox flag.
     */
    public function getUseFancybox() {
        return $this->use_fancybox;
    }
    
}

/**
 * Editor field for relations.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldMMRelation extends editorField {
    
    /**
     * @var string foreign table name.
     */
    private $foreign_table = '';
    
    /**
     * @var array<string> names of fields in which we can filter resultset.
     */
    private $filter_in_fields = NULL;
    
    /**
     * @var array<gridField> list of fields from row in foreign table.
     */
    private $grid_fields = array();
    
    /**
     * @var boolean edit only flag for editing relation only for saved records from parent table.
     */
    private $edit_only = TRUE;
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'mm_relation_field';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'mm_relation_field_' . $this->getField() . '_id';
    }
    
    /**
     * Set the foreign table name.
     * 
     * @param string $table foreign table name.
     * @return editorFieldMMRelation reference to this object.
     */
    public function setForeignTable($table) {
        if (is_string($table)) {
            $this->foreign_table = $table;
        } else {
            throw new exception(get_class($this) . '::setForeignTable argument must be string');
        }
        return $this;
    }
    
    /**
     * Set fields for filtering in.
     * 
     * @param array<string> $fields array of field names.
     * @return editorFieldMMRelation reference to this object.
     */
    public function setFilterInFields($fields) {
        if (is_null($fields)) {
            $this->filter_in_fields = NULL;
        } else if (is_array($fields)) {
            $setTo = array();
            if (count($fields)) {
                foreach ($fields as $field) {
                    if (is_string($field)) {
                        $setTo[] = $field;
                    } else {
                        throw new exception(get_class($this) . '::setFilterInFields argument must be array of strings or null');
                    }
                }
            }
            $this->filter_in_fields = $setTo;
        } else {
            throw new exception(get_class($this) . '::setFilterInFields argument must be array of strings or null');
        }
        return $this;
    }
    
    /**
     * Adds gridField to the list of foreign table row fields.
     * 
     * @param gridField $field grid field object.
     * @return editorFieldMMRelation reference to this object.
     */
    public function addGridField(gridField $field) {
        $fname = $field->getField();
        if (in_array($fname, $this->grid_fields)) { return $this; }
        $this->grid_fields[] = $field;
        return $this;
    }
    
    /**
     * Set the flag for manipulating with relations only for saved parent records.
     * 
     * @param boolean $status TRUE for edit only mode, FALSE for editing relations for saved and non-saved parent records.
     * @return editorFieldMMRelation reference to this object.
     */
    public function setEditOnly($status) {
        if (is_bool($status)) {
            $this->edit_only = $status;
        } else {
            throw new exception(get_class($this) . '::setEditOnly argument must be boolean');
        }
        return $this;
    }
    
    /**
     * Returns foreign table name.
     * 
     * @return string foreign table name.
     */
    public function getForeignTable() {
        return $this->foreign_table;
    }
    
    /**
     * Returns array of fields for filtering.
     * 
     * @return array<string> array of fields for filtering.
     */
    public function getFilterInFields() {
        return $this->filter_in_fields;
    }
    
    /**
     * Returns array of grid fields.
     * 
     * @return array<gridField> grid fields.
     */
    public function getGridFields() {
        return $this->grid_fields;
    }
    
    /**
     * Returns edit only flag.
     * 
     * @return boolean edit only flag.
     */
    public function getEditOnly() {
        return $this->edit_only;
    }
    
}

/**
 * Editor field for iframe subrecords creation/management.
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldIframeForeignRelation extends editorField {
    
    /**
     * @var string name of foreign table to edit in iframes.
     */
    private $foreign_table = '';
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'iframe_foreign_relation';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'iframe_foreign_relation_' . $this->getField() . '_id';
    }
    
    /**
     * Set the name of foreign table to be edited in iframes.
     * 
     * @param string $table foreign table name.
     * @return editorFieldIframeForeignRelation reference to this object.
     */
    public function setForeignTable($table) {
        if (is_string($table)) {
            $this->foreign_table = $table;
        } else {
            throw new exception(get_class($this) . '::setForeignTable argument must be string');
        }
        return $this;
    }
    
    /**
     * Returns the name of foreign table.
     * 
     * @return string foreign table name.
     */
    public function getForeignTable() {
        return $this->foreign_table;
    }
    
}

/**
 * Editor field for hidden element, which points to parent record id.
 * It displays other editorField when parent table is not the same as defined here,
 * or when parent table have not been saved (does not have ID).
 * 
 * @author Andrej Jursa
 * @version 1.0
 */
class editorFieldParentIdRecord extends editorField {
    
    /**
     * @var string parent table name.
     */
    private $parent_table = '';
    
    /**
     * @var editorField field, when parent table is different or parent table id is NULL.
     */
    private $else_field = NULL;
    
    /**
     * Returns field type.
     * 
     * @return string field type.
     */
    public function getFieldType() {
        return 'parent_id_record';
    }
    
    /**
     * Returns field unique id.
     * 
     * @return string field unique id for editor form.
     */
    public function getFieldHtmlID() {
        return 'parent_id_record_' . $this->getField() . '_id';
    }
    
    /**
     * Set the parent table name.
     * 
     * @param string $table name of parent table.
     * @return editorFieldParentIdRecord reference to this object.
     */
    public function setParentTable($table) {
        if (is_string($table)) {
            $this->parent_table = $table;
        } else {
            throw new exception(get_class($this) . '::setParentTable argument must be string');
        }
        return $this;
    }
    
    /**
     * Set the field, which will be displayed if parent table is not matched or its ID is NULL.
     * 
     * @param editorField $field editor field displayed in this case.
     * @return editorFieldParentIdRecord reference to this object.
     */
    public function setElseField(editorField $field) {
        $this->else_field = $field;
        return $this;
    }
    
    /**
     * Returns the parent table name.
     * 
     * @return string parent table name.
     */
    public function getParentTable() {
        return $this->parent_table;
    }
    
    /**
     * Returns the spare editor field.
     * 
     * @return editorField spare editor field.
     */
    public function getElseField() {
        return $this->else_field;
    }
}

?>