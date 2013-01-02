<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Migration_Additional_fields3 extends CI_Migration {

    function up(){
        /**
         * Adds columns to miniapps table.
         */
        $this->dbforge->add_column('miniapps', array(
            'openin' => array(
                'type' => 'varchar',
                'constraint' => '32',
                'default' => 'fancybox_ajax',
                'null' => FALSE,
            ),
            'windowwidth' => array(
                'type' => 'varchar',
                'constraint' => '32',
                'default' => 'auto',
                'null' => false,
            ),
            'windowheight' => array(
                'type' => 'varchar',
                'constraint' => '32',
                'default' => 'auto',
                'null' => false,
            ),
        ));
    }

    function down(){
        /**
         * Drops columns from miniapps table.
         */
        $this->dbforge->drop_column('miniapps', 'openin');
        $this->dbforge->drop_column('miniapps', 'windowwidth');
        $this->dbforge->drop_column('miniapps', 'windowheight');
    }

}

?>