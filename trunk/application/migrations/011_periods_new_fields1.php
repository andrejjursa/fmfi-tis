<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Migration_Periods_new_fields1 extends CI_Migration {

    function up() {
        /**
         * Adds columns bg_color and number_color to periods.     
         */         
        $this->dbforge->add_column('periods',array(
            'bg_color' => array(
                'type' => 'varchar',
                'constraint' => '16',
                'default' => '#000000',
                'null' => FALSE,
            ),
            'number_color' => array(
                'type' => 'varchar',
                'constraint' => '16',
                'default' => '#ffffff',
                'null' => FALSE,
            )            
        ));
            
    }

    function down() {
        /**
         * Drops columns bg_color and number_color from periods.     
         */        
        $this->dbforge->drop_column('periods','bg_color');
        $this->dbforge->drop_column('periods','number_color');    
    }

}

?>