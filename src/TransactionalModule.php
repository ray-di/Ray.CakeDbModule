<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule;

use Ray\CakeDbModule\Annotation\Transactional;
use Ray\Di\AbstractModule;

class TransactionalModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // @Transactional
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('Ray\CakeDbModule\Annotation\Transactional'),
            ['Ray\CakeDbModule\TransactionalInterceptor']
        );
    }
}
