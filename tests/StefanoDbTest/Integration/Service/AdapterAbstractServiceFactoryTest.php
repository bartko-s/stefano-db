<?php
namespace StefanoDbTest\Integration\Service;

use StefanoDb\Adapter\ExtendedAdapterInterface;
use StefanoDb\Adapter\Service\AdapterAbstractServiceFactory;
use StefanoDbTest\TestCase;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class AdapterAbstractServiceFactoryTest
    extends TestCase
{
    /**
    * @var ServiceLocatorInterface
    */
    private $serviceManager;

    protected function setUp() {
        $this->serviceManager = new ServiceManager(array(
            'abstract_factories' => array(AdapterAbstractServiceFactory::class),
        ));

        $this->serviceManager->setService('config', array(
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
     * @param string $serviceName
     */
    public function testValidService($serviceName) {
        $sm = $this->serviceManager;

        $this->assertInstanceOf( ExtendedAdapterInterface::class,
            $sm->get($serviceName));
    }

    public function testInvalidService() {
        $this->expectException(ServiceNotFoundException::class);

        $sm = $this->serviceManager;

        $this->assertInstanceOf(ExtendedAdapterInterface::class,
            $sm->get('unknown'));
    }
}