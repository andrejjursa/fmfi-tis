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
            $editor_settings = $table_collection->getEditorSettings();
            $this->parser->assign('sql_table', $table);
            $this->parser->assign('editor_settings', $editor_settings);
            
            $this->parser->assign('id', NULL);
            $this->parser->assign('parent_id', 0);
        }
        
        $this->_addTemplateJs('admin_editor/editor.js');
        $this->_addTemplateJs('jquery.validate.js');
        $this->_addTemplateJs('jquery.validate.new_rules.js');
        $this->_addTemplateJs('tinymce/jquery.tinymce.js');
        $this->_addTemplateJs('jquery.uploadify.min.js');
        $this->_addTemplateCss('uploadify.css');
        $this->_assignTemplateAdditionals();
        
        $this->parser->parse('backend/admin_editor.newRecord.tpl');
    }
    
    public function saveRecord($table) {
        print_r($this->input->post('data'));
        
        $table_collection = $this->load->table_collection($table);
        if ($table_collection == NULL) {
            $this->parser->assign('error', 'no_table');
            $this->parser->parse('backend/admin_editor.saveRecord.tpl');
        } else {
            $table_row = $this->load->table_row($table);
            if ($table_row == NULL) {
                $this->parser->assign('error', 'no_table');
                $this->parser->parse('backend/admin_editor.saveRecord.tpl');
            } else {
                $id = $this->input->post('row_id');
                $table_row->load($id);
                
                $table_row->prepareEditorSave($this->input->post('data'));
                if ($table_row->save()) {
                    $this->_deleteUnusedFiles();
                    $this->load->helper('url');
                    if ($this->input->post('save_and_edit')) {
                        redirect(createUri('admin_editor', 'editRecord', array($table, $table_row->getId())));
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
    
    public function editRecord($table = NULL, $id = NULL) {
        
    }
    
    public function deleteRecord($table = NULL, $id = NULL) {
        
    }
    
    public function previewRecord($table = NULL, $id = NULL) {
        
    }
    
    public function file_upload($table = NULL) {
        $table_collection = $this->load->table_collection($table);
        
        $this->output->set_content_type('Content-type: text/plain');
        
        if ($table_collection == NULL) {
            $this->output->set_output('Nie je možné urèi cie¾ovú tabu¾ku.');
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
    
    private function _deleteUnusedFiles() {
        $files_fields = $this->input->post('delete_files');
        if (count($files_fields)) {
            foreach($files_fields as $files_field) {
                if (count($files_field)) {
                    foreach($files_field as $files_list) {
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
        }
    }
    
    private function _findUploadField($editor_settings, $field) {
        if (isset($editor_settings['tabs']) && count($editor_settings['tabs'])) {
            foreach ($editor_settings['tabs'] as $tab) {
                $fields = $tab->getFields();
                if (isset($fields[$field]) && $fields[$field] instanceof editorFieldFileUpload) {
                    return $fields[$field];
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