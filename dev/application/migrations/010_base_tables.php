<?php


class Migration_Base_tables extends CI_Migration {

    function up(){
        $this->dbforge->add_column('admins',array(
        'new_email' => array(
                'type' => 'varchar',
                'constraint' => '255',
                'default' => '',
                'null' => FALSE,
            ),
        'validation_token' => array(
                'type' => 'varchar',
                'constraint' => '32',
                'default' => '',
                'null' => FALSE,
            )            
        );
            
    }


    function down(){
        $this->dbforge->drop_column('admins','new_email');
        $this->dbforge->drop_column('admins','validation_token');
    
    }

}


?>
