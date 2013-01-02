<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Migration_Change_fields1 extends CI_Migration {

    function up(){
        /**
         * Changes in physicists fields.
         */
        $this->dbforge->modify_column('physicists', array(
            'birth_year' => array(
                'name' => 'birth_year',
                'unsigned' => FALSE,
                'type' => 'int',
                'constraint' => '4',
                'default' => '0',
            ), 
            'death_year' => array(
                'name' => 'death_year',
                'unsigned' => FALSE,
                'type' => 'int',
                'constraint' => '4',
                'default' => '99999',
            ),
        ));
    }

    function down(){
        /**
         * Revert changes in physicists fields.
         */
        $this->dbforge->modify_column('physicists', array(
            'birth_year' => array(
                'name' => 'birth_year',
                'type' => 'INT',
                'constraint' => '4',
                'unsigned' => TRUE,
                'default' => '0',
            ), 
            'death_year' => array(
                'name' => 'death_year',
                'type' => 'INT',
                'constraint' => '4',
                'unsigned' => TRUE,
                'default' => '99999',
            ),
        ));
    }

}

?>