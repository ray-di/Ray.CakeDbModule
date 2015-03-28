# Ray.CakeDbModule

This is the [CakePHP Database](https://github.com/cakephp/database) Module for [Ray.Di](https://github.com/koriym/Ray.Di)

## Installation

### Composer install

```bash
$ composer require ray/cake-database-module
```

### Module install

You can Inject the database Connection instance to any class this way:

```php
use Ray\Di\AbstractModule;
use Ray\CakeDbModule\CakeDbModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new CakeDbModule('sqlite:///'));

        // or
        $this->install(new CakeDbModule('mysql://root@localhost/cake_db'));
    }
}
```

That will create inject instances of `Cake\Database\Connection` with the SQLite driver using
the memory database or connect to the localhost mysql using the root credentials.

You can also be more specific and pass a configuraiton array as `Cake\Database\Connection` would accept
it:

```php
use Ray\Di\AbstractModule;
use Ray\CakeDbModule\CakeDbModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $config = [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Mysql',
            'username' => 'root',
            'password' => 'root',
            'database' => 'cake'
        ];
        $this->install(new CakeDbModule($config));
    }
}
```

Finally you can rely on already configured connections in cake's `ConnectionManager` and inject connections
by name:

```php
ConnectionManager::config('default', $config);
```

```php
use Ray\Di\AbstractModule;
use Ray\CakeDbModule\CakeDbModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new CakeDbModule('default'));
    }
}
```

### DI trait

You can inject the connection instance on any class by using the `Ray\CakeDbModule\DatabaseInject` trait:

```php
use Ray\CakeDbModule\DatabaseInject;

class MyThing
{
    use DatabaseInject;
}
```

This will make the methods `getDbConnection()` and `setDbConnection()` available in your class and will automatically
inject the Connection instance when `MyThing` is instantiated using the Injector.

### Wrapping methods inside a transaction

You can make any method run inside a transaction by using the `@Transactional` annotation. This is handy for saving operations:

```php
use DateTime;
use Ray\CakeDbModule\Annotation\Trasactional;
use Ray\CakeDbModule\DatabaseInject;

class MyThing
{
    use DatabaseInject;

    /**
     * This will run inside a new transaction
     *
     * @Transactional
     */
    public function storeSomething()
    {
        $this->db->insert(
            'posts',
            ['name' => 'First', 'show_on' => new DateTime('+3 days')],
            ['created' => 'datetime']
        );
    }
}
```


### Demo

    $ php docs/demo/run.php
    // It works!

### Requirements

 * PHP 5.4+
 * hhvm
