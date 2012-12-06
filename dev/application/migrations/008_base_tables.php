<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Base_tables extends CI_Migration {
    
    public function up() {
        /**
         * Add sessions table begin.
         */
        $this->dbforge->add_field(array(
            'session_id' => array(
                'type' => 'varchar',
                'constraint' => '40',
                'default' => '0',
                'null' => FALSE,
            ),
            'ip_address' => array(
                'type' => 'varchar',
                'constraint' => '45',
                'default' => '0',
                'null' => FALSE,
            ),
            'user_agent' => array(
                'type' => 'varchar',
                'constraint' => '120',
                'null' => FALSE,
            ),
            'last_activity' => array(
                'type' => 'int',
                'constraint' => '10',
                'unsigned' => TRUE,
                'default' => 0,
                'null' => FALSE,
            ),
            'user_data' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
        ));
        
        $this->dbforge->add_key('session_id', TRUE);
        $this->dbforge->add_key('last_activity');
        
        $this->dbforge->create_table('sessions');
        /**
         * Add sessions table end.
         */
    }
    
    public function down() {
        /**
         * Drop sessions table.
         */
        $this->dbforge->drop_table('sessions');
    }
    
}
    
?>