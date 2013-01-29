<?php

define('BASEPATH', '');

function config() {
    include_once ('application/config/config.php');
    
    if (isset($config)) {
        return $config;
    }
    return null;
}

$config = config();

if ($config === null) {
    echo 'ERROR: CAN\'T LOAD CONFIG FILE, CAN\'T REDIRECT TO ADMIN<br />USE LINK: index.php/admin';
} else {
    $admin_url = rtrim($config['base_url'], '/') . '/index.php/admin';
    header('location: ' . $admin_url);
}

?>