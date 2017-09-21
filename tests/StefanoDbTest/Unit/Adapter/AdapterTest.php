<?php
namespace StefanoDbTest\Unit\Adapter;

use StefanoDb\Adapter\Adapter;
use StefanoDb\Adapter\ExtendedAdapterInterface;
use StefanoDb\Transaction\Adapter as TransactionAdapter;
use StefanoNestedTransaction\TransactionManager;
use StefanoNestedTransaction\TransactionManagerInterface;
use Zend\Db\Adapter\Driver\Pdo\Pdo;

class AdapterTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Adapter
     */
    protected $adapter;

    protected function setUp() {
        $driverStub = \Mockery::mock(Pdo::class);
        $driverStub->shouldReceive('getDatabasePlatformName')
                   ->andReturn('Mysql');
        $driverStub->shouldReceive('checkEnvironment')
                   ->andReturn(true);

        $this->adapter = new Adapter($driverStub);
    }

    protected function tearDown() {
        $this->adapter = null;
    }

    public function testImplementsExtendedAdapterInterface() {
        $this->assertInstanceOf(ExtendedAdapterInterface::class, $this->adapter);
    }

    public function testSetGetTransaction() {
        $transactionStub = \Mockery::mock(TransactionAdapter::class);

        $transaction = new TransactionManager($transactionStub);

        $dbAdapter = $this->adapter;
        $dbAdapter->setTransaction($transaction);
        $this->assertSame($transaction, $dbAdapter->getTransaction());
    }

    public function testLazyLoadedTransaction() {
        $dbAdapter = $this->adapter;
        $this->assertInstanceOf(TransactionManagerInterface::class,
                $dbAdapter->getTransaction());
        $this->assertSame($dbAdapter->getTransaction(), $dbAdapter->getTransaction()); //return same object
    }

    public function testBeginTransaction() {
        $transactionManagerMock = \Mockery::mock(TransactionManager::class);
        $transactionManagerMock->shouldReceive('begin')
                               ->once();

        $dbAdapter = $this->adapter
                          ->setTransaction($transactionManagerMock);

        $dbAdapter->begin();
    }

    public function testCommitTransaction() {
        $transactionManagerMock = \Mockery::mock(TransactionManager::class);
        $transactionManagerMock->shouldReceive('commit')
                               ->once();

        $dbAdapter = $this->adapter
                          ->setTransaction($transactionManagerMock);

        $dbAdapter->commit();
    }

    public function testRollbackTransaction() {
        $transactionManagerMock = \Mockery::mock(TransactionManager::class);
        $transactionManagerMock->shouldReceive('rollback')
                               ->once();

        $dbAdapter = $this->adapter
                          ->setTransaction($transactionManagerMock);

        $dbAdapter->rollback();
    }
}