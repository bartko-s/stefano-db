Stefano Db
===================

| Master Build | Develop Build |
| :---: | :---: |
| <a href="https://travis-ci.org/bartko-s/stefano-db"><img src="https://secure.travis-ci.org/bartko-s/stefano-db.png?branch=master" /></a> | <a href="https://travis-ci.org/bartko-s/stefano-db"><img src="https://secure.travis-ci.org/bartko-s/stefano-db.png?branch=develop" /></a> |

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