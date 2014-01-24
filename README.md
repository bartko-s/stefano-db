Stefano Db
===================

| Test Status | Code Coverage | Dependencies |
| :---: | :---: | :---: |
| <a href="https://travis-ci.org/bartko-s/stefano-db"><img src="https://secure.travis-ci.org/bartko-s/stefano-db.png?branch=master" /></a> | <a href='https://coveralls.io/r/bartko-s/stefano-db?branch=master'><img src='https://coveralls.io/repos/bartko-s/stefano-db/badge.png?branch=master' alt='Coverage Status' /></a> | <a href='https://www.versioneye.com/user/projects/51bc294809732f0002004f51'><img src='https://www.versioneye.com/user/projects/51bc294809732f0002004f51/badge.png' alt="Dependency Status" /></a> |

Instalation using Composer
--------------------------
1. Add following line to composer.json  ``` "stefano/stefano-db": "*" ```

Features
------------
- extend Zend Framework 2 Database adapter. For more info see [Zend Db](http://framework.zend.com/manual/2.2/en/index.html#zend-db)
- nested transaction. For more info see [Stefano nested transaction](https://github.com/bartko-s/stefano-nested-transaction/)
- db adapter service manager initializer

Service keys
------------
- StefanoDb\Adapter\Adapter or Zend\Db\Adapter\Adapter or DbAdapter return \StefanoDb\Adapter\Adapter instance

Service Initializers
--------------------
- inject \StefanoDb\Adapter\Adapter instance into all service which implements \StefanoDb\Adapter\AdapterAwareInterface or \Zend\Db\Adapter\AdapterAwareInterface

Usage
-------

- adapter configuration

```
//$option for more info see Zend Framework 2 Db documentation
$adapter = new \StefanoDb\Adapter\Adapter($options);
```

- nested transaction api

```
$transaction = $adapter->getTransaction();

$transaction->begin();
$transaction->commit();
$transaction->rollback();
```