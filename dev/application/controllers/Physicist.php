<?php if (!defined('APPPATH')) { die('No direct access allowed ...'); }

class Physicist extends Abstract_frontend_controller {
    
    public function index($id = 1){
      $id = (int) $id;
		
		  $physicist = $this->load->table_row('physicists');
		  $physicist->load($id);
		
		  $this->parser->parse("frontend/physicist.index.tpl", $physicist );
    
    }  

}

?>
