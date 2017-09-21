<?php
namespace StefanoDbTest\Integration\Service;

use Zend\ServiceManager\ServiceManager;

class AdapterServiceFactoryTest
    extends \PHPUnit_Framework_TestCase
{
    /**
    * @var \Zend\ServiceManager\ServiceLocatorInterface
    */
    private $serviceManager;

    protected function setUp() {
        $this->serviceManager = new ServiceManager(array(
            'factories' => array(
                'DbAdapter' => '\StefanoDb\Adapter\Service\AdapterServiceFactory'),
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

        $this->assertInstanceOf('\StefanoDb\Adapter\ExtendedAdapterInterface',
            $sm->get('DbAdapter'));
    }
}