<?php

class Blog extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library('parser');
        
        $this->parser->assign('domain', 'http://localhost/tis/tech_demo/');
    }
    
    public function index() {
        $blog_entries = $this->load->table_collection('blog_entries')->orderBy('crdate', 'asc')->execute()->get();
        
        $this->parser->parse('blog_index.tpl', array('blog_entries' => $blog_entries), FALSE, FALSE);
    }
    
    private function _entry($id) {
        $this->parser->registerPlugin('function', 'form_errors', 'my_validation_errors');
        
        $data['blog_entry'] = $this->load->table_row('blog_entries');
        $data['blog_entry']->load($id);
        
        $this->parser->parse('blog_entry.tpl', $data, FALSE, FALSE);
    }
    
    public function entry() {
        $get_data = $this->uri->uri_to_assoc();
        
        $id = NULL;
        
        if (isset($get_data['id']) && is_numeric($get_data['id'])) {
            $id = intval($get_data['id']);
        }
        
        $this->_entry($id);
    }
    
    public function add_comment() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('comment[author]', 'Autor', 'required');
        $this->form_validation->set_rules('comment[text]', 'Text', 'required');
        $this->form_validation->set_rules('comment[blog_entry_id]', 'Sprava z blogu', 'callback_blogEntryExists');
        
        if ($this->form_validation->run()) {
            $blog_comments_row = $this->load->table_row('blog_comments');
            $blog_comments_row->data($this->input->post('comment', TRUE));
            $blog_comments_row->save();
            
            $this->load->helper('url');
            
            redirect('blog/entry/id/' . $this->input->post('comment')['blog_entry_id']);
        } else {
            $this->_entry($this->input->post('comment')['blog_entry_id']);
        }
    }
    
    public function blogEntryExists($string) {
        $table = $this->load->table_row('blog_entries');
        $table->load(intval($string));
        return !is_null($table->getId());
    }
}

function my_validation_errors($params, $smarty) {
    $CI =& get_instance();
    
    $CI->load->helper('form');
    
    return validation_errors();
}

?>