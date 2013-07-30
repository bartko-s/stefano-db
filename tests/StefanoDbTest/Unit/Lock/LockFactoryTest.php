<?php
namespace StefanoDbTest\Unit\Lock;

use StefanoDb\Lock\LockFactory;

class LockFactoryTest
    extends \PHPUnit_Framework_TestCase
{       
    /**
     * @param \Zend\Db\Adapter\Driver\DriverInterface $driverInterface
     * @return \Zend\Db\Adapter\Adapter
     */
    private function getDbAdapterStub(\Zend\Db\Adapter\Driver\DriverInterface $driverStub) {
        $dbAdapterStub = \Mockery::mock('\Zend\Db\Adapter\Adapter');
        $dbAdapterStub->shouldReceive('getDriver')
                      ->andReturn($driverStub);
        
        return $dbAdapterStub;
    }
    
    public function testRecognizeDbPlatformAndReturnProperLockAdapter() {
        $driverStub = \Mockery::mock('\Zend\Db\Adapter\Driver\DriverInterface');
        $driverStub->shouldReceive('getDatabasePlatformName')
                   ->andReturn('Postgresql');
        
        $dbAdapterStub = $this->getDbAdapterStub($driverStub);
        
        $lockFactory = new LockFactory();
        
        $this->assertInstanceOf('\StefanoDb\Lock\Adapter\Postgresql',
                $lockFactory->getLockAdapter($dbAdapterStub),
                'Given adapter must be \StefanoDb\Lock\Adapter\Postresql instance');
        
        $this->assertInstanceOf('\StefanoDb\Lock\LockInterface',
                $lockFactory->getLockAdapter($dbAdapterStub),
                'Given adapter must implements \StefanoDb\Lock\LockInterface');
    }
    
    public function testThrowAnExceptionIfLockAdapterForGivenDbPlatformIsNotSupported() {
        $this->setExpectedException('\StefanoDb\Exception\InvalidArgumentException',
                'Lock Adapter for "Dont-exist" does not exist');
        
        $driverStub = \Mockery::mock('\Zend\Db\Adapter\Driver\DriverInterface');
        $driverStub->shouldReceive('getDatabasePlatformName')
                   ->andReturn('Dont-exist');
        
        $dbAdapterStub = $this->getDbAdapterStub($driverStub);
        
        $lockFactory = new LockFactory();        
        $lockFactory->getLockAdapter($dbAdapterStub);
    }
}