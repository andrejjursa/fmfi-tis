<?php

$config['menu'] = array(
    array(
        'title' => 'Správa záznamov',
        'link' => 'javascript:void(0)',
        'sub' => array(
            array(
                'title' => 'Fyzici',
                'link' => array(
                    'controller' => 'admin_editor',
                    'action' => 'index',
                    'params' => array('physicists'),
                ),
                'sub' => NULL,
            ),
            array(
                'title' => 'Obrázky',
                'link' => array(
                    'controller' => 'admin_editor',
                    'action' => 'index',
                    'params' => array('images'),
                ),
                'sub' => NULL,
            ),
        ),
    ),
);

?>