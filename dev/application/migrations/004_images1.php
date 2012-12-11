<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }
    
class Migration_Images1 extends CI_Migration {
    
    public function up() {
        /**
         * Add images table begin.
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
            'file' => array(
                'type' => 'text',
                'null' => FALSE,
            ),
            'description' => array(
                'type' => 'varchar',
                'constraint' => '255',
                'default' => '',
            ),
        ));
        
        $this->dbforge->add_key('id', TRUE);
        
        $this->dbforge->create_table('images');
        /**
         * Add images table end.
         */
        
        /**
         * Add physicists_images_mm table begin.
         */
        $this->dbforge->add_field(array(
            'image_id' => array(
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
        
        $this->dbforge->add_key('image_id');
        $this->dbforge->add_key('physicist_id');
        
        $this->dbforge->create_table('physicists_images_mm');
        /**
         * Add physicists_images_mm table end.
         */
        
        /**
         * Add inventions_images_mm table begin.
         */
        $this->dbforge->add_field(array(
            'image_id' => array(
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
        
        $this->dbforge->add_key('image_id');
        $this->dbforge->add_key('invention_id');
        
        $this->dbforge->create_table('inventions_images_mm');
        /**
         * Add inventions_images_mm table end.
         */
    }
    
    public function down() {
        /**
         * Drop images table.
         */
        $this->dbforge->drop_table('images');
        /**
         * Drop physicists_images_mm table.
         */
        $this->dbforge->drop_table('physicists_images_mm');
        /**
         * Drop inventions_images_mm table.
         */
        $this->dbforge->drop_table('inventions_images_mm');
    }
    
}
    
?>