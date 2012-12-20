<?php

$config['menu'] = array(
    array(
        'title' => 'Správa obsahu',
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
                'title' => 'Obdobia',
                'link' => array(
                    'controller' => 'admin_editor',
                    'action' => 'index',
                    'params' => array('periods'),
                ),
                'sub' => NULL,
            ),				
            array(
                'title' => 'Objavy',
                'link' => array(
                    'controller' => 'admin_editor',
                    'action' => 'index',
                    'params' => array('inventions'),
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
            array(
                'title' => 'Miniaplikácie',
                'link' => array(
                    'controller' => 'admin_editor',
                    'action' => 'index',
                    'params' => array('miniapps'),
                ),
                'sub' => NULL,
            ),           
        ),
    ),
	array(
        'title' => 'Záloha a obnovenie',
        'link' => 'javascript:void(0)',
        'sub' => array(
            array(
                'title' => 'Vytvoriť zálohu',
                'link' => array(
                    'controller' => 'admin_backup',
                    'action' => 'index',
                    'params' => array(),
                ),
                'sub' => NULL,
            ),
			 array(
                'title' => 'Obnoviť zo zálohy',
                'link' => array(
                    'controller' => 'admin_backup',
                    'action' => 'restore',
                    'params' => array(),
                ),
                'sub' => NULL,
            ),
		)
	),
    array(
        'title' => 'Môj účet&nbsp;&nbsp;&nbsp;&nbsp;',
        'link' => 'javascript:void(0)',
        'sub' => array(
            array(
                'title' => 'Zmeniť email',
                'link' => array(
                    'controller' => 'user',
                    'action' => 'changeForm',
                    'params' => array("email"),
                ),
                'sub' => NULL,
            ),
            array(
                'title' => 'Zmeniť heslo',
                'link' => array(
                    'controller' => 'user',
                    'action' => 'changeForm',
                    'params' => array("password"),
                ),
                'sub' => NULL,
            ),
        )
    ),    
    array(
        'title' => 'Administrátori',
        'link' => array(
            'controller' => 'admin_editor',
            'action' => 'index',
            'params' => array('admins'),
        ),
        'sub' => NULL,
    ),
    array(
        'title' => 'Záznamy udalostí',
        'link' => array(
            'controller' => 'admin_editor',
            'action' => 'index',
            'params' => array('logs'),
        ),
        'sub' => NULL,
    ),
    array(
        'title' => 'Odhlásiť sa',
        'link' => array(
            'controller' => 'admin',
            'action' => 'logout',
            'params' => array(),
        ),
        'class' => 'logout_menu_button',
        'sub' => NULL,
    ),
);

?>
