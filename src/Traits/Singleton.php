<?php

declare(strict_types=1);

/**
 * This file is part of FooZ79.
 *
 * @link     https://github.com/fooz79/php-helper
 * @license  https://github.com/fooz79/php-helper/blob/master/LICENSE
 */

namespace FooZ79\Traits;

trait Singleton
{
    protected static $instance = [];

    protected static function getSingleton(array $args)
    {
        $className = md5(static::class);
        static::$instance[$className] = static::$instance[$className] ?? null;
        if (static::$instance[$className] instanceof static) {
            return static::$instance[$className];
        } else {
            if ((new \ReflectionMethod(static::class, '__construct'))->isPublic()) {
                $className = (new \ReflectionClass(static::class))->getShortName();
                throw new \Exception($className . '::__construct() can\'t be public');
            } else {
                self::$instance[$className] = new static(...$args);
                return static::$instance[$className];
            }
        }
    }

    public function __destruct()
    {
        unset(static::$instance[md5(static::class)]);
    }

    public function __clone()
    {
        throw new \Exception('Can\'t clone a singleton');
    }

    public function __sleep()
    {
        throw new \Exception('Can\'t serialize a singleton');
    }
}
