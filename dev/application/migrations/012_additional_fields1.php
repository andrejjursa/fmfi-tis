<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Migration_Additional_fields1 extends CI_Migration {

    function up(){
        /**
         * Adds columns to logs table.
         */
        $this->dbforge->add_column('logs', array(
            'ipaddress' => array(
                'type' => 'varchar',
                'constraint' => '16',
                'default' => '',
                'null' => FALSE,
            ),
        ));
        /**
         * Adds columns to physicists table.
         */
        $this->dbforge->add_column('physicists', array(
            'questionscount' => array(
                'type' => 'int',
                'constraint' => '4',
                'default' => '10',
                'null' => FALSE,
            ),
        ));
    }


    function down(){
        /**
         * Drops columns from logs table.
         */
        $this->dbforge->drop_column('logs', 'ipaddress');
        /**
         * Drops columns from physicists table.
         */
        $this->dbforge->drop_column('physicists', 'questionscount');    
    }

}

?>