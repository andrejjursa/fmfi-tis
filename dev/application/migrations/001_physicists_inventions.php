<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Physicists_inventions extends CI_Migration {
    
    public function up() {
        /**
         * Add physicists table begin.
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
            'birth_year' => array(
                'type' => 'INT',
                'constraint' => '4',
                'unsigned' => TRUE,
                'default' => '0',
            ),
            'death_year' => array(
                'type' => 'INT',
                'constraint' => '4',
                'unsigned' => TRUE,
                'default' => '99999',
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'short_description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'displayed' => array(
                'type' => 'INT',
                'constraint' => '1',
                'default' => '0',
            ),
            'photo' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0',
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        
        $this->dbforge->create_table('physicists');
        /**
         * Add physicists table end.
         */
         
        /**
         * Add inventions table begin.
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
            ),
            'year' => array(
                'type' => 'int',
                'constraint' => '4',
                'default' => '0',
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'short_description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'displayed' => array(
                'type' => 'INT',
                'constraint' => '1',
                'default' => '0',
            ),
            'photo' => array(
                'type' => 'INT',
                'constraint' => '11',
                'default' => '0',
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        
        $this->dbforge->create_table('inventions');
        /**
         * Add inventions table end.
         */
    }
    
    public function down() {
        /**
         * Drop physicists table.
         */
        $this->dbforge->drop_table('physicists');
        
        /**
         * Drop inventions table.
         */ 
        $this->dbforge->drop_table('inventions');
    }
    
}
    
?>