<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule;

use Cake\Database\Connection;
use Ray\Di\Di\Inject;

trait DatabaseInject
{
    /**
     * @var \Cake\Database\Connection
     */
    private $db;

    /**
     * @param \Cake\Database\Connection $db
     *
     * @Inject
     * @return void
     */
    public function setDbConnection(Connection $db = null)
    {
        $this->db = $db;
    }

	public function getDbConnection()
    {
        return $this->db;
    }
}
