<?php

declare(strict_types=1);

/**
 * This file is part of FooZ79.
 *
 * @link     https://gitee.com/FooZ/traits
 * @license  https://gitee.com/FooZ/traits/blob/master/LICENSE
 */

namespace FooZ79\Traits;

trait Singleton
{
    private static $instance = null;

    public static function getSingleton(...$args)
    {
        if (is_null(self::$instance)) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
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
