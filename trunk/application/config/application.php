<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Boolean expression determining installed status of this application.
| DO NOT CHANGE MANUALLY UNLESS YOU KNOW WHAT YOU DOING!
|--------------------------------------------------------------------------
*/
$config['installed'] = false;
/*
|--------------------------------------------------------------------------
| Enable use of mod rewrite for links.
|--------------------------------------------------------------------------
|
| Boolean expression, TRUE for enabled state, FALSE otherwise.
|
*/
$config['rewrite_enabled'] = false;
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
$config['grid_rows_per_page_possibilities'] = array (
  0 => 20,
  1 => 50,
  2 => 100,
);
/*
|--------------------------------------------------------------------------
| Login controller and action for administrator login.
|--------------------------------------------------------------------------
|
| String values for controller and action. 
|
*/
$config['admin_login_controller'] = 'admin';
$config['admin_login_action'] = 'login';
$config['tmp_path'] = 'application/tmp/';
$config['backup_path'] = 'application/backup/';
/*
|--------------------------------------------------------------------------
| Email configuration.
|--------------------------------------------------------------------------
*/
$config['email']['protocol'] = 'mail';
$config['email']['smtp_host'] = '';
$config['email']['smtp_port'] = '';
$config['email']['smtp_user'] = '';
$config['email']['smtp_pass'] = '';
$config['email']['mailtype'] = 'html';
$config['email']['charset'] = 'utf-8';
$config['email']['wordwrap'] = true;
$config['email_from'] = 'noreply@nomail.org';
$config['email_from_name'] = 'No name';
/* End of file application.php */
/* Location: ./application/config/application.php */


?>