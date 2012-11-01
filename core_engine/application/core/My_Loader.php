<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extended version of CI_Loader.
 * 
 * This one can load new type of table models, which are rows and collections.
 *
 * @author Andrej Jursa
 * @version 1.0
 * @copyright FMFI Comenius University in Bratislava 2012
 * 
 */

class My_Loader extends CI_Loader {
    
    public function __construct() {
        parent::__construct();
    }
    
}

?>