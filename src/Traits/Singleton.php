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

    public static function getSingleton(...$args)
    {
        $className = md5(static::class);
        if (isset(self::$instance[$className]) == false) {
            self::$instance[$className] = new static(...$args);
        }
        return self::$instance[$className];
    }

    public static function releaseSingleton()
    {
        unset(self::$instance[md5(static::class)]);
    }

    public function __clone()
    {
        throw new \Exception('Cannot clone a singleton');
    }

    public function __sleep()
    {
        throw new \Exception('Cannot serialize a singleton');
    }
}
