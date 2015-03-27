<?php
/**
 * This file is part of the Ray.CakeDbModule package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace Ray\CakeDbModule;

use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Doctrine\DBAL\DriverManager;
use Ray\CakeDbModule\Annotation\CakeDbConfig;
use Ray\Di\Di\Named;
use Ray\Di\ProviderInterface;

class ConnectionProvider implements ProviderInterface
{
    /**
     * @var array|string
     */
    private $config;

    /**
     * @param string $config
     *
     * @CakeDbConfig
     */
    public function __construct($config)
    {
        if (is_array($config)) {
            $this->config = $config;

            return;
        }

        if (!class_exists('Cake\Datasource\ConnectionManager')) {
            throw new \InvalidArgumentException('Could not parse configuration for @CakeDbConfig');
        }

        if (strpos($config, '://') !== false) {
            $this->config = ConnectionManager::parseDsn($config);
            return;
        }

        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        if (is_string($this->config)) {
            return ConnectionManager::get($this->config);
        }
        return new Connection($this->config);
    }
}
