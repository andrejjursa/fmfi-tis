<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Enable use of mod rewrite for links.
|--------------------------------------------------------------------------
|
| Boolean expression, TRUE for enabled state, FALSE otherwise.
|
*/
$config['rewrite_enabled'] = TRUE;

/*
|--------------------------------------------------------------------------
| Default number of rows in editor grid.
|--------------------------------------------------------------------------
|
| Integer expression, 20 is default settings.
|
*/
$config['grid_default_rows_per_page'] = 20;

/*
|--------------------------------------------------------------------------
| Possible numbers of rows per page in editor grid.
|--------------------------------------------------------------------------
|
| Array of integers.
|
*/
$config['grid_rows_per_page_possibilities'] = array(20, 50, 100);

$config['admin_login_controller'] = 'admin';
$config['admin_login_action'] = 'login';

/* End of file application.php */
/* Location: ./application/config/application.php */
