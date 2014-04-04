<?php
namespace StefanoDbTest\Integration;

use StefanoDbTest\AbstractTestCase;

class ServiceTest
    extends AbstractTestCase
{
    public function testDbAdapter() {
        $sm = $this->getFreshServiceLocator();

        $this->assertInstanceOf('\StefanoDb\Adapter\Adapter',
            $sm->get('DbAdapter'));
        $this->assertInstanceOf('\StefanoDb\Adapter\Adapter',
            $sm->get('StefanoDb\Adapter\Adapter'));
        $this->assertInstanceOf('\StefanoDb\Adapter\Adapter',
            $sm->get('Zend\Db\Adapter\Adapter'));

        //must return same instance
        $adapter = $sm->get('DbAdapter');
        $this->assertSame($adapter, $sm->get('StefanoDb\Adapter\Adapter'));
        $this->assertSame($adapter, $sm->get('Zend\Db\Adapter\Adapter'));
    }
}