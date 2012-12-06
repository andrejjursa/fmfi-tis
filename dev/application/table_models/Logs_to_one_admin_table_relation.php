<?php

class Logs_to_one_admin_table_relation extends Abstract_table_relation {
    
    public function __construct() {
        $this->foreign_table_name = 'admins';
        $this->relation_type_mm = FALSE;
    }
    
}

?>