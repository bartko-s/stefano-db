[DEPRECATED] Stefano Db
=======================

Zend DB from [v.2.4.0](https://github.com/zendframework/zend-db/releases/tag/release-2.4.0) support nested transactions. Please use [Zend Db](https://github.com/zendframework/zend-db/) instead of this library. This library is NOT MAINTAINED anymore.

[![Build Status](https://app.travis-ci.com/bartko-s/stefano-db.svg?branch=master)](https://app.travis-ci.com/bartko-s/stefano-db)
[![Code Coverege](https://coveralls.io/repos/bartko-s/stefano-db/badge.png?branch=master)](https://coveralls.io/r/bartko-s/stefano-db?branch=master)

Installation using Composer
--------------------------
1. Run command  ``` composer require stefano/stefano-db ```

Features
------------
- extend Zend Framework 2 Database adapter. For more info see [Zend Db](http://framework.zend.com/manual/2.3/en/index.html#zend-db)
- nested transaction. For more info see [Stefano nested transaction](https://github.com/bartko-s/stefano-nested-transaction/)
- execute defined queries after db connection will be created


Db Adapter Configuration
------------------------

```
//$option for more info see Zend Framework 2 Db documentation
$adapter = new \StefanoDb\Adapter\Adapter($options);
```

Nested transaction API
----------------------

```
$adapter->begin();
$adapter->commit();
$adapter->rollback();
```

Usage with Zend Framework 2 MVC
-------------------------------

- single DB connection configuration

```
return array(
    //single DB connection
    'db' => array(
        'driver' => '',
        'database' => '',
        'username' => '',
        'password' => '',
        'sqls' => array(
            "SET time_zone='+0:00'",
            "....."
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                => '\StefanoDb\Adapter\Service\AdapterServiceFactory',
        ),
    ),
);
```

- multiple DB connection configuration

```
return array(
    'db' => array(
        'adapters' => array(
            'Db/Write' => array(
                'driver' => '',
                'database' => '',
                'username' => '',
                'password' => '',
                'sqls' => array(
                    "SET time_zone='+0:00'",
                    "....."
                ),
            ),
            'Db/Read' => array(
                'driver' => '',
                'database' => '',
                'username' => '',
                'password' => '',
                'sqls' => array(
                    "SET time_zone='+0:00'",
                    "....."
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            '\StefanoDb\Adapter\Service\AdapterAbstractServiceFactory',
        ),
    ),
);
```
