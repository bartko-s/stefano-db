<?php
namespace StefanoDbTest\Unit\Adapter;

use StefanoDb\Adapter\AdapterFactory;
use StefanoDb\Adapter\ExtendedAdapterInterface;
use StefanoDb\MultiQuery;
use StefanoDbTest\TestCase;

class AdapterFactoryTest
    extends TestCase
{
    public function testCreateDbAdapter() {
        $adapterConfig = array(
            'driver' => 'Pdo_Sqlite',
            'database' => ':memory:',
        );

        $adapterFactory = new AdapterFactory();

        $this->assertInstanceOf(ExtendedAdapterInterface::class,
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

        $multiQueryMock = \Mockery::mock(MultiQuery::class);
        $multiQueryMock->shouldReceive('execute')
                       ->with(\Mockery::any(), $adapterConfig['sqls'])
                       ->once();

        $adapterFactory = new AdapterFactory($multiQueryMock);
        $adapterFactory->create($adapterConfig);
    }
}