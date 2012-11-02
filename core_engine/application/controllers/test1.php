<?php

class Test1 extends Abstract_backend_controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $this->load->database();
        echo 'FUNGUJE!!!';
        
        $collection = $this->load->table_collection('blog_entries');
        $count = $collection->count();
        $collection->execute();
        
        echo '<pre>';
        echo 'There are ' . $count . ' blog entries.<br /><br />';
        if (count($collection->get()) > 0) {
            foreach ($collection->get() as $entry) {
                echo 'Title: ' . $entry->getTitle() . '<br />';
                echo '<br />' . $entry->getBody() . '<br />';
                if (count($entry->getImages()) > 0) {
                    echo 'Images: ';
                    foreach ($entry->getImages() as $image) {
                        echo $image->getFile() . ' ';
                    }
                    echo '<br />';
                }
                if (count($entry->getTags()) > 0) {
                    echo 'Tags: ';
                    foreach ($entry->getTags() as $tag) {
                        echo $tag->getTagname() . ' ';
                    }
                    echo '<br />';
                }
                if (count($entry->getComments()) > 0) {
                    echo 'Comments: <br />';
                    foreach ($entry->getComments() as $comment) {
                        echo '<br />' . $comment->getText() . '<br />';
                    }
                }
                echo '<hr >';
            }
        }
        echo '</pre>';
    }
    
}

?>