<?php
namespace StefanoDbTest\Unit;

use StefanoDb\Adapter\Adapter as DbAdapter;
use StefanoDb\MultiQuery;

class MultiQueryTest
    extends \PHPUnit_Framework_TestCase
{
    public function testExecute() {
        $queries = array(
            'firts query',
            'secound query',
        );

        $adapterMock = \Mockery::mock(DbAdapter::class);
        $adapterMock->shouldReceive('query')
                    ->with($queries[0], DbAdapter::QUERY_MODE_EXECUTE)
                    ->once()
                    ->ordered();
        $adapterMock->shouldReceive('query')
                    ->with($queries[1], DbAdapter::QUERY_MODE_EXECUTE)
                    ->once()
                    ->ordered();

        $multiQuery = new MultiQuery();
        $multiQuery->execute($adapterMock, $queries);
    }
}