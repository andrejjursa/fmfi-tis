<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Migration_Periods_mm1 extends CI_Migration {
    
    public function up() {
        /**
         * Add periods_physicists_mm table begin.
         */
        $this->dbforge->add_field(array(
            'period_id' => array(
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
        
        $this->dbforge->add_key('period_id');
        $this->dbforge->add_key('physicist_id');
        
        $this->dbforge->create_table('periods_physicists_mm');
        /**
         * Add periods_physicists_mm table end.
         */
         
        /**
         * Add periods_inventions_mm table begin.
         */
        $this->dbforge->add_field(array(
            'period_id' => array(
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
        
        $this->dbforge->add_key('period_id');
        $this->dbforge->add_key('invention_id');
        
        $this->dbforge->create_table('periods_inventions_mm');
        /**
         * Add periods_inventions_mm table end.
         */
    }
    
    public function down() {
        /**
         * Drop periods_physicists_mm table.
         */
        $this->dbforge->drop_table('periods_physicists_mm');
        /**
         * Drop periods_inventions_mm table.
         */
        $this->dbforge->drop_table('periods_inventions_mm');
    }
        
}

?>