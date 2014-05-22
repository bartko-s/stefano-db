<?php
namespace StefanoDbTest\Unit;

use StefanoDb\MultiQuery;

class MultiQueryTest
    extends \PHPUnit_Framework_TestCase
{
    public function testExecute() {
        $queries = array(
            'firts query',
            'secound query',
        );

        $adapterMock = \Mockery::mock('\StefanoDb\Adapter\Adapter');
        $adapterMock->shouldReceive('query')
                    ->with($queries[0], \StefanoDb\Adapter\Adapter::QUERY_MODE_EXECUTE)
                    ->once()
                    ->ordered();
        $adapterMock->shouldReceive('query')
                    ->with($queries[1], \StefanoDb\Adapter\Adapter::QUERY_MODE_EXECUTE)
                    ->once()
                    ->ordered();

        $multiQuery = new MultiQuery();
        $multiQuery->execute($adapterMock, $queries);
    }
}