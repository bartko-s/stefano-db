<?php
namespace StefanoDbTest\Integration\Service;

use StefanoDb\Adapter\ExtendedAdapterInterface;
use StefanoDb\Adapter\Service\AdapterServiceFactory;
use StefanoDbTest\TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class AdapterServiceFactoryTest
    extends TestCase
{
    /**
    * @var ServiceLocatorInterface
    */
    private $serviceManager;

    protected function setUp(): void {
        $this->serviceManager = new ServiceManager(array(
            'factories' => array(
                'DbAdapter' => AdapterServiceFactory::class),
        ));

        $this->serviceManager->setService('Config', array(
            'db' => array(
                'driver' => 'Pdo_Sqlite',
                'database' => ':memory:',
            ),
        ));
    }

    public function testCreateDbAdapter() {
        $sm = $this->serviceManager;

        $this->assertInstanceOf(ExtendedAdapterInterface::class,
            $sm->get('DbAdapter'));
    }
}