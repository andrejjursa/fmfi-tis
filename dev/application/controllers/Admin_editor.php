<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Admin_editor extends Abstract_backend_controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->parser->disable_caching();
    }
    
    public function index($table = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
        } else {
            $grid_settings = $table_collection->getGridSettings();
            if ($grid_settings['enabled']) {
                $this->parser->assign('sql_table', $table);
                $this->parser->assign('grid_settings', $grid_settings);
                
                $this->_applySorting($table_collection);
                
                $max_pages = $table_collection->getPagesCount($this->_numberOfRowsPerPage());
                $table_collection->paginate($this->_pageNumber($max_pages), $this->_numberOfRowsPerPage());
                
                $this->parser->assign('current_page', $this->_pageNumber($max_pages));
                $this->parser->assign('current_rows_per_page', $this->_numberOfRowsPerPage());
                $this->parser->assign('max_pages', $max_pages);
                $this->parser->assign('rows_per_pages_options', self::getConfigItem('application', 'grid_rows_per_page_possibilities'));
                
                $this->parser->assign('rows', $table_collection->execute()->get());
            } else {
                $this->parser->assign('error', 'disabled');
            }
        }
        
        $this->_addTemplateJs('admin_editor/index.js');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin_editor.index.tpl', array());
    }
    
    public function newRecord($table = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
        } else {
            $table_collection->getGridSettings();
            if ($table_collection->isNewRecordEnabled()) {
                $editor_settings = $table_collection->getEditorSettings();
                $this->parser->assign('sql_table', $table);
                $this->parser->assign('editor_settings', $editor_settings);
                
                $this->parser->assign('id', NULL);
                $this->parser->assign('parent_table', '');
                $this->parser->assign('parent_id', 0);
            } else {
                $this->parser->assign('error', 'no_new_record');
            }
        }
        
        $this->_addTemplateJs('admin_editor/editor.js');
        $this->_addTemplateJs('jquery.validate.js');
        $this->_addTemplateJs('jquery.validate.new_rules.js');
        $this->_addTemplateJs('tinymce/jquery.tinymce.js');
        $this->_addTemplateJs('jquery.uploadify.min.js');
        $this->_addTemplateJs('jquery.iframe-auto-height.js');
        $this->_addTemplateCss('uploadify.css');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin_editor.newRecord.tpl');
    }
    
    public function newRecordIframe($table = NULL, $parent_id = 0, $parent_table = '') {
        $table_collection = $this->load->table_collection($table);
        
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
        } else {
            $table_collection->getGridSettings();
            if ($table_collection->isNewRecordEnabled()) {
                $editor_settings = $table_collection->getEditorSettings();
                $this->parser->assign('sql_table', $table);
                $this->parser->assign('editor_settings', $editor_settings);
                
                $this->parser->assign('id', NULL);
                $this->parser->assign('parent_table', $parent_table);
                $this->parser->assign('parent_id', $parent_id);
            } else {
                $this->parser->assign('error', 'no_new_record');
            }
        }
        
        $this->_addTemplateJs('admin_editor/editor.js');
        $this->_addTemplateJs('jquery.validate.js');
        $this->_addTemplateJs('jquery.validate.new_rules.js');
        $this->_addTemplateJs('tinymce/jquery.tinymce.js');
        $this->_addTemplateJs('jquery.uploadify.min.js');
        $this->_addTemplateJs('jquery.iframe-auto-height.js');
        $this->_addTemplateCss('uploadify.css');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin_editor.newRecordIframe.tpl');
    }
    
    public function saveRecord($table) {
        $table_collection = $this->load->table_collection($table);
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
            $this->parser->parse('backend/admin_editor.saveRecord.tpl');
        } else {
            $table_collection->getGridSettings();
            $table_row = $this->load->table_row($table);
            if ($table_row == NULL) {
                $this->parser->assign('error', 'no_table');
                $this->parser->parse('backend/admin_editor.saveRecord.tpl');
            } else {
                $id = $this->input->post('row_id');
                $table_row->load($id);
                
                if ($table_row->getId() === NULL && !$table_collection->isNewRecordEnabled()) {
                    $this->parser->assign('error', 'no_new_record');
                    $this->parser->parse('backend/admin_editor.saveRecord.tpl');
                } else if ($table_row->getId() !== NULL && !$table_collection->isEditRecordEnabled()) {
                    $this->parser->assign('error', 'no_edit_record');
                    $this->parser->parse('backend/admin_editor.saveRecord.tpl');
                } else {
                    $table_row->prepareEditorSave($this->input->post('data'));
                    if ($table_row->save()) {
                        $this->_deleteUnusedFiles();
                        $this->load->helper('url');
                        if ($this->input->post('save_and_edit')) {
                            redirect(createUri('admin_editor', 'editRecord', array($table, $table_row->getId())));
                        } else if ($this->input->post('save_and_iframe')) {
                            $parent_id = $this->input->post('parent_id');
                            $parent_table = $this->input->post('parent_table');
                            redirect(createUri('admin_editor', 'editRecordIframe', array($table, $table_row->getId(), $parent_id, $parent_table)));
                        } else {
                            redirect(createUri('admin_editor', 'index', array($table)));
                        }
                    } else {
                        $this->parser->assign('error', 'cannot_save_data');
                        $this->parser->parse('backend/admin_editor.saveRecord.tpl');
                    }
                }
            }
        }
    }
    
    public function editRecord($table = NULL, $id = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
        } else {
            $gridsettings = $table_collection->getGridSettings();
            if ($table_collection->isEditRecordEnabled()) {
                $table_row = $this->load->table_row($table);
                $table_row->load($id);
                if (!is_null($table_row->getId())) {
                    $editor_settings = $table_collection->getEditorSettings();
                    $this->parser->assign('sql_table', $table);
                    $this->parser->assign('editor_settings', $editor_settings);
                    
                    $this->parser->assign('id', $table_row->getId());
                    $this->parser->assign('parent_id', 0);
                    $this->parser->assign('parent_table', $table);
                    $this->parser->assign('data', $table_row->getDataForEditor());
                    $this->parser->assign('gridSettings', $gridsettings);
                } else {
                    $this->parser->assign('error', 'unknown_record');
                }
            } else {
                $this->parser->assign('error', 'no_edit_record');
            }
        }
        
        $this->_addTemplateJs('admin_editor/editor.js');
        $this->_addTemplateJs('jquery.validate.js');
        $this->_addTemplateJs('jquery.validate.new_rules.js');
        $this->_addTemplateJs('tinymce/jquery.tinymce.js');
        $this->_addTemplateJs('jquery.uploadify.min.js');
        $this->_addTemplateJs('jquery.iframe-auto-height.js');
        $this->_addTemplateCss('uploadify.css');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin_editor.editRecord.tpl');
    }
    
    public function editRecordIframe($table = NULL, $id = NULL, $parent_id = NULL, $parent_table = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
        } else {
            $gridsettings = $table_collection->getGridSettings();
            if ($table_collection->isEditRecordEnabled()) {
                $table_row = $this->load->table_row($table);
                $table_row->load($id);
                if (!is_null($table_row->getId())) {
                    $editor_settings = $table_collection->getEditorSettings();
                    $this->parser->assign('sql_table', $table);
                    $this->parser->assign('editor_settings', $editor_settings);
                    
                    $this->parser->assign('id', $table_row->getId());
                    $this->parser->assign('parent_id', $parent_id);
                    $this->parser->assign('parent_table', $parent_table);
                    $this->parser->assign('data', $table_row->getDataForEditor());
                    $this->parser->assign('gridSettings', $gridsettings);
                } else {
                    $this->parser->assign('error', 'unknown_record');
                }
            } else {
                $this->parser->assign('error', 'no_edit_record');
            }
        }
        
        $this->_addTemplateJs('admin_editor/editor.js');
        $this->_addTemplateJs('jquery.validate.js');
        $this->_addTemplateJs('jquery.validate.new_rules.js');
        $this->_addTemplateJs('tinymce/jquery.tinymce.js');
        $this->_addTemplateJs('jquery.uploadify.min.js');
        $this->_addTemplateJs('jquery.iframe-auto-height.js');
        $this->_addTemplateCss('uploadify.css');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin_editor.editRecordIframe.tpl');
    }
    
    public function deleteRecord($table = NULL, $id = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if (is_null($table_collection)) {
            $this->parser->assign('error', 'no_table');
            $this->parser->parse('backend/admin_editor.deleteRecord.tpl');
        } else {
            $table_collection->getGridSettings();
            $table_row = $this->load->table_row($table);
            if ($table_row == NULL) {
                $this->parser->assign('error', 'no_table');
                $this->parser->parse('backend/admin_editor.deleteRecord.tpl');
            } else {
                if ($table_collection->isDeleteRecordEnabled()) {
                    $table_row->load($id);
                    if (!is_null($table_row->getId())) {
                        $table_row->delete();
                        $this->load->helper('url');
                        redirect(createUri('admin_editor', 'index', array($table)));
                    } else {
                        $this->parser->assign('error', 'cant_delete_data');
                        $this->parser->parse('backend/admin_editor.deleteRecord.tpl');
                    }
                } else {
                    $this->parser->assign('error', 'no_delete_record');
                    $this->parser->parse('backend/admin_editor.deleteRecord.tpl');
                }
            }
        }
    }
    
    public function deleteRecordIframe($table = NULL, $id = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        if (is_null($table_collection)) {
            $this->parser->assign('error', 'no_table');
            $this->parser->parse('backend/admin_editor.deleteRecordIframe.tpl');
        } else {
            $table_collection->getGridSettings();
            $table_row = $this->load->table_row($table);
            if ($table_row == NULL) {
                $this->parser->assign('error', 'no_table');
                $this->parser->parse('backend/admin_editor.deleteRecordIframe.tpl');
            } else {
                if ($table_collection->isDeleteRecordEnabled()) {
                    $table_row->load($id);
                    if (!is_null($table_row->getId())) {
                        $table_row->delete();
                        $this->parser->assign('success', true);
                        $this->parser->parse('backend/admin_editor.deleteRecordIframe.tpl');
                    } else {
                        $this->parser->assign('error', 'cant_delete_data');
                        $this->parser->parse('backend/admin_editor.deleteRecordIframe.tpl');
                    }
                } else {
                    $this->parser->assign('error', 'no_delete_record');
                    $this->parser->parse('backend/admin_editor.deleteRecordIframe.tpl');
                }
            }
        }
    }
    
    public function previewRecord($table = NULL, $id = NULL) {
        
    }
    
    public function file_upload($table = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        $this->output->set_content_type('Content-type: text/plain');
        
        if ($table_collection == NULL) {
            $this->output->set_output('Nie je možné urei? cie3ovú tabu3ku.');
        } else {
            $editor_settings = $table_collection->getEditorSettings();
            
            $field_name = $this->input->post('field');
            $parent_id = $this->input->post('parent_id');
            
            $field_config = $this->_findUploadField($editor_settings, $field_name);
            
            if (is_null($field_config)) {
                $this->output->set_output('Chyba konfigurácie vstupného pola.');
                return;    
            }
            
            $config = array(
                'upload_path' => trim(str_replace('{$parent_id}', $parent_id, $field_config->getUploadPath()), '/') . '/',
                'allowed_types' => '*',
            );
 
            $this->_makeUploadPath($config['upload_path']);
            
            $this->load->library('upload', $config);
                
            if ($this->upload->do_upload('Filedata')) {
                $data = $this->upload->data();
                $this->output->set_output('!OK!' . $config['upload_path'] . $data['file_name']);
                return;
            }  
            
            $this->output->set_output($this->upload->display_errors('', '') . ' (Typ súboru je ' . $_FILES['Filedata']['type'] . ')');
            return;
        }
    }
    
    public function mm_relation_field($table = NULL, $field = NULL, $excludeIds = '', $like = '') {
        $table_collection = $this->load->table_collection($table);
        
        $excludeIds = $this->input->post('excludeIds');
        $like = $this->input->post('like');
        $onlyIds = $this->input->post('onlyIds');
        
        if (is_null($table_collection)) {
            $this->parser->assign('error', 'no_table');
        } else {
            $editor_settings = $table_collection->getEditorSettings();
            $editor_field = $this->_findMMRelationField($editor_settings, $field);
            if (is_null($editor_field)) {
                $this->parser->assign('error', 'no_field');
            } else {
                $foreign_table_collection = $this->load->table_collection($editor_field->getForeignTable());
                if (is_null($foreign_table_collection)) {
                    $this->parser->assign('error', 'no_table');
                } else {
                    $this->load->database();
                    $custom_where = '';
                    if (!empty($like)) {
                        $filtered_fields = $editor_field->getFilterInFields();
                        if (count($filtered_fields)) {
                            $or_like = array();
                            foreach ($filtered_fields as $filtered_field) {
                                $or_like[] = $this->db->protect_identifiers($filtered_field) . ' LIKE "%' . $this->db->escape_like_str($like) . '%"';       
                            }
                            if (count($or_like)) {
                                $custom_where .= '(' . implode(' OR ', $or_like) . ')';
                            }
                        }
                    }
                    if ($excludeIds != '') {
                        $custom_where .= empty($custom_where) ? '' : ' AND ';
                        $custom_where .= $this->db->protect_identifiers($foreign_table_collection->primaryIdField()) . ' NOT IN (' . $excludeIds . ')';
                    }
                    if ($onlyIds != '') {
                        $custom_where = $this->db->protect_identifiers($foreign_table_collection->primaryIdField()) . ' IN (' . $onlyIds . ')';
                    }
                    $foreign_table_collection->filterCustomWhere($custom_where);
                    $rows = $foreign_table_collection->execute()->get();
                    
                    $this->parser->assign('gridFields', $editor_field->getGridFields());
                    $this->parser->assign('rows', $rows);
                }
            }
        }
        
        $this->parser->parse('partials/admin_editor.mm_relation.list.tpl');
    }
    
    private function _deleteUnusedFiles() {
        $files_fields = $this->input->post('delete_files');
        if (count($files_fields)) {
            foreach($files_fields as $files_list) {
                $files = explode('|', $files_list);
                if (count($files)) {
                    foreach($files as $file) {
                        $trimedfile = ltrim($file, '/');
                        if (substr($trimedfile, 0, 14) == 'public/uploads' && file_exists($trimedfile)) {
                            unlink($trimedfile);
                        }
                    }
                }
            }
        }
    }
    
    private function _findUploadField($editor_settings, $field) {
        if (isset($editor_settings['tabs']) && count($editor_settings['tabs'])) {
            foreach ($editor_settings['tabs'] as $tab) {
                $fields = $tab->getFields();
                if (isset($fields[$field]) && $fields[$field] instanceof editorFieldFileUpload) {
                    return $fields[$field];
                } else if (isset($fields[$field])) {
                    $fld = $fields[$field];
                    while (!is_null($fld) && $fld instanceof editorFieldParentIdRecord) {
                        $fld = $fld->getElseField();
                        if ($fld instanceof editorFieldFileUpload && $fld->getField() == $field) {
                            return $fld;
                        }
                    }
                }
            }
        }
        return NULL;
    }
    
    private function _findMMRelationField($editor_settings, $field) {
        if (isset($editor_settings['tabs']) && count($editor_settings['tabs'])) {
            foreach ($editor_settings['tabs'] as $tab) {
                $fields = $tab->getFields();
                if (isset($fields[$field]) && $fields[$field] instanceof editorFieldMMRelation) {
                    return $fields[$field];
                } else if (isset($fields[$field])) {
                    $fld = $fields[$field];
                    while (!is_null($fld) && $fld instanceof editorFieldParentIdRecord) {
                        $fld = $fld->getElseField();
                        if ($fld instanceof editorFieldMMRelation && $fld->getField() == $field) {
                            return $fld;
                        }
                    }
                }
            }
        }
        return NULL;
    }
    
    private function _makeUploadPath($path) {
        @mkdir($path, 0777, TRUE);
    }
    
    private function _numberOfRowsPerPage() {
        $post = $this->input->post();
        if ($post === FALSE || !isset($post['paginate']['rows_per_page'])) {
            return intval(self::getConfigItem('application', 'grid_default_rows_per_page'));
        }
        return intval($post['paginate']['rows_per_page']);
    }
    
    private function _pageNumber($max_pages) {
        $post = $this->input->post();
        if ($post === FALSE || !isset($post['paginate']['page'])) {
            return 1;
        }
        if (intval($post['paginate']['page']) > $max_pages) {
            return $max_pages;
        }
        return intval($post['paginate']['page']);
    }
    
    private function _applySorting(Abstract_table_collection $table_collection) {
        $post = $this->input->post();
        if ($post === FALSE || !isset($post['sorting']['by']) || empty($post['sorting']['by'])) { return; }
        
        $sort_by = $post['sorting']['by'];
        $sort_direction = isset($post['sorting']['direction']) ? $post['sorting']['direction'] : 'DESC';
        
        $table_collection->orderBy($sort_by, $sort_direction);
    }
}

?>