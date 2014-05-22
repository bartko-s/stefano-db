<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                => '\StefanoDb\Adapter\Service\AdapterFactory',
        ),
        'aliases' => array(
            'StefanoDb\Adapter\Adapter' => 'Zend\Db\Adapter\Adapter',
            'DbAdapter' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    'db' => array(

    ),
    'stefano_db' => array(

    ),
);