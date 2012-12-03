<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Base_tables extends CI_Migration {
    
    public function up() {
        /**
         * Add periods table begin.
         */
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ),              
            'tstamp' => array(
                'type' => 'timestamp',
            ),
            'crdate' => array(
                'type' => 'timestamp',
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => '255',
                'default' => '',
                'null' => FALSE,
            ),
            'description' => array(
                'type' => 'TEXT',
				'default' => '',
                'null' => TRUE,
            ),
            'image' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
            'start_year' => array(
                'type' => 'int',
                'constraint' => '4',
                'default' => '0',
            ),
            'end_year' => array(
                'type' => 'int',
                'constraint' => '4',
                'default' => '9999',
            ),			
        ));
        
        $this->dbforge->add_key('id', TRUE);
        
        $this->dbforge->create_table('periods');
        /**
         * Add periods table end.
         */

    }
    
    public function down() {
        /**
         * Drop periods table.
         */
        $this->dbforge->drop_table('periods');

    }
    
}
    
?>