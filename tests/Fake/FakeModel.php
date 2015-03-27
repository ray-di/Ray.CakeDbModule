<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule;

use Aura\Sql\ExtendedPdo;
use Ray\CakeDbModule\Annotation\Transactional;

class FakeModel
{
    use DatabaseInject;

    /**
     * @Transactional
     */
    public function go()
    {
        return true;
    }

    /**
     * @Transactional("default")
     */
    public function dbError()
    {
        $this->db->execute('xxx');
    }
}
