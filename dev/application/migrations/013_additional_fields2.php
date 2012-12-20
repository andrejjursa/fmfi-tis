<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Migration_Additional_fields2 extends CI_Migration {

    function up(){
        /**
         * Adds columns to physicists table.
         */
        $this->dbforge->add_column('physicists', array(
            'links' => array(
                'type' => 'text',
                'default' => '',
                'null' => TRUE,
            ),
            'links_labels' => array(
                'type' => 'text',
                'default' => '',
                'null' => TRUE,
            ),
        ));
        /**
         * Adds columns to inventions table.
         */
        $this->dbforge->add_column('inventions', array(
            'links' => array(
                'type' => 'text',
                'default' => '',
                'null' => TRUE,
            ),
            'links_labels' => array(
                'type' => 'text',
                'default' => '',
                'null' => TRUE,
            ),
        ));
        /**
         * Adds columns to periods table.
         */
        $this->dbforge->add_column('periods', array(
            'border_color' => array(
                'type' => 'varchar',
                'constraint' => '16',
                'default' => '#000000',
                'null' => FALSE,
            ),
        ));
    }

    function down(){
        /**
         * Drops columns from physicists table.
         */
        $this->dbforge->drop_column('physicists', 'links');
        $this->dbforge->drop_column('physicists', 'links_labels');  
        /**
         * Drops columns from inventions table.
         */
        $this->dbforge->drop_column('inventions', 'links');
        $this->dbforge->drop_column('inventions', 'links_labels');
        /**
         * Drops columns from periods table.
         */  
        $this->dbforge->drop_column('periods', 'border_color');
    }

}

?>