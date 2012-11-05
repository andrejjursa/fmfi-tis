<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_entries_to_blog_comments_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->local_table_name = 'blog_entries';
        $this->foreign_index_field = 'blog_entry_id';
        $this->foreign_primary_field = 'id';
        $this->foreign_table_name = 'blog_comments';
        $this->relation_type_mm = FALSE;
    }
    
}

?>