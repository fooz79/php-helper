<?php

declare(strict_types=1);

use FooZ79\Statics\Env;

/**
 * This file is part of FooZ79.
 *
 * @link     https://gitee.com/FooZ/traits
 * @license  https://gitee.com/FooZ/traits/blob/master/LICENSE
 */

if (strstr(__DIR__, 'vendor')) {
    define('FOOZ79_PROJECT_ROOT', dirname(dirname(dirname(dirname(__DIR__)))));
} else {
    define('FOOZ79_PROJECT_ROOT', dirname(__DIR__));
}
define('FOOZ79_ROOT_DIR', FOOZ79_PROJECT_ROOT . DIRECTORY_SEPARATOR);
define('FOOZ79_RUNTIME_DIR', FOOZ79_ROOT_DIR . 'runtime' . DIRECTORY_SEPARATOR);
define('FOOZ79_CONFIG_DIR', FOOZ79_ROOT_DIR . 'config' . DIRECTORY_SEPARATOR);
define('FOOZ79_DATA_DIR', FOOZ79_ROOT_DIR . 'data' . DIRECTORY_SEPARATOR);
define('FOOZ79_NS', '\\');

if (!function_exists('getSingleton')) {
    function getSingleton($class, ...$args)
    {
        return ($class)::getSingleton(...$args);
    }
}

if (!function_exists('env')) {
    function env(string $section, string $setting, $default = null)
    {
        return Env::get($section . '.' . $setting,  $default);
    }
}
