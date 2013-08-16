<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'StefanoDb\Adapter\Adapter'
                => '\StefanoDb\Adapter\Service\AdapterFactory',
        ),
        'aliases' => array(
            'Zend\Db\Adapter\Adapter' => 'StefanoDb\Adapter\Adapter',
            'DbAdapter' => 'StefanoDb\Adapter\Adapter',
        ),
        'initializers' => array(
            'StefanoDbAdapterInitializer'
                => '\StefanoDb\Initializer\DbInitializer'
        ),
    ),    
    'db' => array(
        
    ),
    'stefano_db' => array(
        
    ),
);