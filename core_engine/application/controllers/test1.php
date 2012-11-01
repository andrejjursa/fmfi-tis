<?php

class Test1 extends Abstract_backend_controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->database();
        echo 'FUNGUJE!!!';
        
        $collection = $this->load->table_collection('blog_entries');
        $collection->orderBy('title', 'asc')->orderBy('', 'random')->limit(100)->onlyNewEntries();
        
        echo '<pre>';
        print_r($collection->count());
        print_r($collection);
        echo '</pre>';
    }
    
}

?>