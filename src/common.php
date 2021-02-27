<?php

declare(strict_types=1);

use FooZ79\Statics\Env;

/**
 * helper function from fooz79.
 *
 * @link     https://github.com/fooz79/php-helper
 * @license  https://github.com/fooz79/php-helper/blob/master/LICENSE
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

if (!function_exists('get_caller_class')) {
    /**
     * Get the name of the external object calling the current object
     *
     * @param boolean $shortName    use short names
     * @return string|null
     */
    function get_caller_class(bool $shortName = false): ?string
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $count = count($trace);
        if ($count > 2) {
            $file = $trace[0]['file'];
            $class = $trace[1]['class'];
            for ($i = 1; $i <= $count; ++$i) {
                if ($file != $trace[$i + 1]['file']) {
                    if ($class != $trace[$i]['class']) {
                        if ($shortName) {
                            return (new \ReflectionClass($trace[$i]['class']))->getShortName();;
                        } else {
                            return $trace[$i]['class'];
                        }
                    } else {
                        $class = $trace[$i]['class'];
                    }
                }
            }
        }
        return null;
    }
}
