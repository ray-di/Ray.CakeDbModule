<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class Transactional
{
    public $value;
}
