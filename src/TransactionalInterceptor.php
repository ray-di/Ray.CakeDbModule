<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\CakeDbModule\Exception\RollbackException;

class TransactionalInterceptor implements MethodInterceptor
{
    /**
     * {@inheritdoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $object = $invocation->getThis();

        if (!method_exists($object, 'getDbConnection')) {
            throw new \RuntimeException('The object needs to implement getDbConnection');
        }

        $object->getDbConnection()->transactional(function () use (&$result, $invocation) {
            $result = $invocation->proceed();
        });
        return $result;
    }
}
