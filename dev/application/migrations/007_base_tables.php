<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Base_tables extends CI_Migration {
    
    public function up() {
        /**
         * Add logs table begin.
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
            'admin_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'default' => '0',
            ),			
            'message' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
            'data' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        
        $this->dbforge->create_table('logs');
        /**
         * Add logs table end.
         */
    }
    
    public function down() {
        /**
         * Drop logs table.
         */
        $this->dbforge->drop_table('logs');
    }
    
}
    
?>