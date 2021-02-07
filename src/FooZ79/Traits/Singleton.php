<?php

/**
 * This file is part of FooZ79.
 *
 * @link     https://gitee.com/FooZ/traits
 * @license  https://gitee.com/FooZ/traits/blob/master/LICENSE
 */

declare(strict_types=1);

namespace FooZ79\Traits;

trait Singleton
{
    private static $instance;

    public static function getInstance(...$args)
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}
