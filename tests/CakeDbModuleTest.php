<?php

namespace Ray\CakeDbModule;

use Cake\Datasource\ConnectionManager;
use Ray\Di\Injector;

class CakeDbModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testModule()
    {
        $module = new CakeDbModule(['driver' => 'Cake\Database\Driver\Sqlite']);
        $instance = (new Injector($module, $_ENV['TMP_DIR']))
            ->getInstance('Cake\Database\Connection');

        $this->assertInstanceOf('Cake\Database\Connection', $instance);
        $this->assertInstanceOf('Cake\Database\Driver\Sqlite', $instance->driver());
    }

    public function testWithDsn()
    {
        $module = new CakeDbModule('sqlite:///:memory:');
        $instance = (new Injector($module, $_ENV['TMP_DIR']))
            ->getInstance('Cake\Database\Connection');

        $this->assertInstanceOf('Cake\Database\Connection', $instance);
    }

    public function testWithPreMadeConnection()
    {
        ConnectionManager::config('default', [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Sqlite'
        ]);
        $module = new CakeDbModule('default');
        $instance = (new Injector($module, $_ENV['TMP_DIR']))
            ->getInstance('Cake\Database\Connection');

        $this->assertSame(ConnectionManager::get('default'), $instance);
    }

    public function testTransactional()
    {
        $module = new CakeDbModule(['driver' => 'Cake\Database\Driver\Sqlite']);
        $instance = (new Injector($module, $_ENV['TMP_DIR']))
            ->getInstance('Ray\CakeDbModule\FakeModel');

        $this->assertInstanceOf('Cake\Database\Connection', $instance->getDbConnection());
        $mock = $this
            ->getMockBuilder('Cake\Database\Connection')
            ->setMethods(['begin', 'commit'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())->method('begin');
        $mock->expects($this->once())->method('commit');
        $instance->setDbConnection($mock);
        $this->assertTrue($instance->go());
    }

    public function testTransactionalError()
    {
        $module = new CakeDbModule(['driver' => 'Cake\Database\Driver\Sqlite']);
        $instance = (new Injector($module, $_ENV['TMP_DIR']))
            ->getInstance('Ray\CakeDbModule\FakeModel');

        $this->setExpectedException('\PDOException');
        $instance->dbError();
    }
}
