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
    private static $instance;

    public static function getInstance(...$args)
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}
