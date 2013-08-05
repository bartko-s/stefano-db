Stefano Db
===================

| Test Status | Dependencies |
| :---: | :---: |
| <a href="https://travis-ci.org/bartko-s/stefano-db"><img src="https://secure.travis-ci.org/bartko-s/stefano-db.png?branch=master" /></a> | <a href='https://www.versioneye.com/user/projects/51bc294809732f0002004f51'><img src='https://www.versioneye.com/user/projects/51bc294809732f0002004f51/badge.png' alt="Dependency Status" /></a> |

Instalation using Composer
--------------------------
1. Add following line to composer.json  ``` "stefano/stefano-db": "*" ```

Features
------------
- transaction manager
- lock table
- extended db adapter
- db adapter service manager initializer

Service keys
------------
- StefanoDb\Adapter\Adapter or Zend\Db\Adapter\Adapter or DbAdapter return \StefanoDb\Adapter\Adapter instance

Service Initializers
--------------------
- inject \StefanoDb\Adapter\Adapter instance into all service which implements \StefanoDb\Adapter\AdapterAwareInterface or \Zend\Db\Adapter\AdapterAwareInterface

ToDo
-------
- unit tests