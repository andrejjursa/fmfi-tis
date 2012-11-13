<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Base_tables extends CI_Migration {
    
    public function up() {
        /**
         * Add questions table begin.
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
            'question' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
            'image' => array(
                'type' => 'varchar',
                'constraint' => '255',
                'default' => '',
            ),
            'physicist_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'default' => '0',
            ),
            'value' => array(
                'type' => 'INT',
                'constraint' => '4',
                'unsigned' => TRUE,
                'default' => '0',
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('physicist_id');
        
        $this->dbforge->create_table('questions');
        /**
         * Add questions table end.
         */
         
        /**
         * Add answers table begin.
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
            'answer' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
            'image' => array(
                'type' => 'varchar',
                'constraint' => '255',
                'default' => '',
            ),
            'correct' => array(
                'type' => 'INT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'default' => '0',
            ),
            'question_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'default' => '0',
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('question_id');
        
        $this->dbforge->create_table('answers');
        /**
         * Add answers table end.
         */
    }
    
    public function down() {
        /**
         * Drop questions table.
         */
        $this->dbforge->drop_table('questions');
        /**
         * Drop answers table.
         */
        $this->dbforge->drop_table('answers');
    }
    
}
    
?>