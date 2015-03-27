<?php

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use Ray\CakeDbModule\DatabaseInject;
use Ray\CakeDbModule\CakeDbModule;
use Ray\Di\Injector;

class Fake
{
    use DatabaseInject;

    public function foo()
    {
        return $this->db;
    }
}

$fake = (new Injector(new CakeDbModule(['driver' => 'Cake\Database\Driver\Sqlite'])))->getInstance('Fake');
$works = ($fake->foo() instanceof \Cake\Database\Connection);

echo ($works ? 'It works!' : 'It DOES NOT work!') . PHP_EOL;
