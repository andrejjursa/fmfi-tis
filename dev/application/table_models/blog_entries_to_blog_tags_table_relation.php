<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_entries_to_blog_tags_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->relation_type_mm = TRUE;
        $this->mm_table_name = 'blog_entries_tags_mm';
        $this->mm_local_id_field = 'entry_id';
        $this->mm_foreign_id_field = 'tag_id';
        $this->mm_sorting_field = 'sorting';
        $this->foreign_table_name = 'blog_tags';
        $this->foreign_primary_field = 'id';
    }
      
}

?>