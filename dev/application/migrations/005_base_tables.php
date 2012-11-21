<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Base_tables extends CI_Migration {
    
    public function up() {
        /**
         * Add miniapps table begin.
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
            'headerhtml' => array(
                'type' => 'text',
                'null' => TRUE,
            ),
            'bodyhtml' => array(
                'type' => 'text',
                'null' => FALSE,
            )
        ));
        
        $this->dbforge->add_key('id', TRUE);
        
        $this->dbforge->create_table('miniapps');
        /**
         * Add miniapps table end.
         */
         
        /**
         * Add miniapp_files table begin.
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
            'miniapp_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'default' => '0',
            ),
            'file' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('miniapp_id');
        
        $this->dbforge->create_table('miniapp_files');
        /**
         * Add miniapp_files table end.
         */

        /**
         * Add inventions_miniapps_mm table begin.
         */
        $this->dbforge->add_field(array(
            'miniapp_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
            ),              
            'invention_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
            ),
            'sorting' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'default' => '0',
            ),
        ));
        
        $this->dbforge->add_key('miniapp_id');
        $this->dbforge->add_key('invention_id');
        
        $this->dbforge->create_table('inventions_miniapps_mm');
        /**
         * Add inventions_miniapps_mm table end.
         */

        /**
         * Add physicists_miniapps_mm table begin.
         */
        $this->dbforge->add_field(array(
            'miniapp_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
            ),              
            'physicist_id' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
            ),
            'sorting' => array(
                'type' => 'INT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'default' => '0',
            ),
        ));
        
        $this->dbforge->add_key('miniapp_id');
        $this->dbforge->add_key('physicist_id');
        
        $this->dbforge->create_table('physicists_miniapps_mm');
        /**
         * Add physicists_miniapps_mm table end.
         */
    }
    
    public function down() {
        /**
         * Drop miniapps table.
         */
        $this->dbforge->drop_table('miniapps');
        /**
         * Drop miniapp_files table.
         */
        $this->dbforge->drop_table('miniapp_files');
        /**
         * Drop inventions_miniapps_mm table.
         */
        $this->dbforge->drop_table('inventions_miniapps_mm');
        /**
         * Drop physicists_miniapps_mm table.
         */
        $this->dbforge->drop_table('physicists_miniapps_mm');
    }
}