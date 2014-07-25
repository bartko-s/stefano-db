Stefano Db
===================

| Test Status | Code Coverage | Dependencies |
| :---: | :---: | :---: |
| [![Test Status](https://secure.travis-ci.org/bartko-s/stefano-db.png?branch=master)](https://travis-ci.org/bartko-s/stefano-db) | [![Code Coverege](https://coveralls.io/repos/bartko-s/stefano-db/badge.png?branch=master)](https://coveralls.io/r/bartko-s/stefano-db?branch=master) | [![Dependencies](https://www.versioneye.com/user/projects/51bc294809732f0002004f51/badge.png)](https://www.versioneye.com/user/projects/51bc294809732f0002004f51) |

Instalation using Composer
--------------------------
1. Add following line to composer.json  ``` "stefano/stefano-db": "*" ```

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
adapter->begin();
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
