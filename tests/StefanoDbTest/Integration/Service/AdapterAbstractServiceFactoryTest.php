<?php
namespace StefanoDbTest\Integration\Service;

use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\Config as ServiceManagerConfig;

class AdapterAbstractServiceFactoryTest
    extends \PHPUnit_Framework_TestCase
{
    /**
    * @var \Zend\ServiceManager\ServiceLocatorInterface
    */
    private $serviceManager;

    protected function setUp() {
        $this->serviceManager = new ServiceManager(new ServiceManagerConfig(array(
            'abstract_factories' => array('\StefanoDb\Adapter\Service\AdapterAbstractServiceFactory'),
        )));

        $this->serviceManager->setService('Config', array(
            'db' => array(
                'adapters' => array(
                    'Db/Write' => array(
                        'driver' => 'Pdo_Sqlite',
                        'database' => ':memory:',
                    ),
                    'Db/Read' => array(
                        'driver' => 'Pdo_Sqlite',
                        'database' => ':memory:',
                    ),
                ),
            ),
        ));
    }

    public function validServices() {
        return array(
            array('Db/Write'),
            array('Db/Read'),
        );
    }

    /**
     * @dataProvider validServices
     * @param type $serviceName
     */
    public function testValidService($serviceName) {
        $sm = $this->serviceManager;

        $this->assertInstanceOf('\StefanoDb\Adapter\ExtendedAdapterInterface',
            $sm->get($serviceName));
    }

    public function testInvalidService() {
        $this->setExpectedException('\Zend\ServiceManager\Exception\ServiceNotFoundException');

        $sm = $this->serviceManager;

        $this->assertInstanceOf('\StefanoDb\Adapter\ExtendedAdapterInterface',
            $sm->get('unknown'));
    }
}