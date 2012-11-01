<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blog_entries_to_blog_images_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->foreign_table_name = 'blog_images';
        $this->foreign_primary_field = 'id';
    }
    
}

?>