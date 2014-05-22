<?php
namespace StefanoDbTest\Unit\Adapter;

use StefanoDb\Adapter\AdapterFactory;

class AdapterFactoryTest
    extends \PHPUnit_Framework_TestCase
{
    public function testCreateDbAdapter() {
        $adapterConfig = array(
            'driver' => 'Pdo_Sqlite',
            'database' => ':memory:',
        );

        $adapterFactory = new AdapterFactory();

        $this->assertInstanceOf('\StefanoDb\Adapter\ExtendedAdapterInterface',
            $adapterFactory->create($adapterConfig));
    }

    public function testExecuteQueriesAfterDbAdapterIsCreated() {
        $adapterConfig = array(
            'driver' => 'Pdo_Sqlite',
            'database' => ':memory:',
            'sqls' => array(
                "SELECT date('now')",
            ),
        );

        $multiQueryMock = \Mockery::mock('\StefanoDb\MultiQuery');
        $multiQueryMock->shouldReceive('execute')
                       ->with(\Mockery::any(), $adapterConfig['sqls'])
                       ->once();

        $adapterFactory = new AdapterFactory($multiQueryMock);
        $adapterFactory->create($adapterConfig);
    }
}