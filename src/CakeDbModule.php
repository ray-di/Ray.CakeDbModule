<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class CakeDbModule extends AbstractModule
{
    /**
     * @var string|array
     */
    private $config;

    /**
     * @param string $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        AnnotationRegistry::registerFile(__DIR__ . '/DoctrineAnnotations.php');
        $this->bind()
            ->annotatedWith('Ray\CakeDbModule\Annotation\CakeDbConfig')
            ->toInstance($this->config);


        $this->bind('Cake\Database\Connection')
            ->toProvider('Ray\CakeDbModule\ConnectionProvider')
            ->in(Scope::SINGLETON);

        $this->install(new TransactionalModule);
    }
}
