<?php

class Test1 extends Abstract_backend_controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        echo 'FUNGUJE!!!';
    }
    
}

?>