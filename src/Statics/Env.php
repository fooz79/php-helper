<?php

declare(strict_types=1);

namespace FooZ79\Statics;

class Env
{
    private const ENV_PREFIX = 'FOOZ79_';

    private static $loaded = null;

    public static function get(string $name, $default = null)
    {
        if (is_null(self::$loaded)) self::loadFile();

        $result = getenv(static::ENV_PREFIX . strtoupper(str_replace('.', '_', $name)));
        if (false !== $result) {
            if ('false' === $result) {
                $result = false;
            } elseif ('true' === $result) {
                $result = true;
            }
            return $result;
        }
        return $default;
    }

    public static function getString(string $name, $default = null): string
    {
        return strval(self::get($name, $default));
    }

    public static function getInt(string $name, $default = null): int
    {
        return intval(self::get($name, $default));
    }

    public static function getFloat(string $name, $default = null, int $precision = 4): float
    {
        return round(self::get($name, $default), $precision);
    }

    public static function getArray(string $name, $default = null, string $separator = ',', array $replace_pairs = null): array
    {
        if (is_null($replace_pairs)) {
            $replace_pairs = [
                ' ' => ''
            ];
        }
        return explode($separator, strtr(self::getString($name, $default), $replace_pairs));
    }

    private static function loadFile($filePath = null): void
    {
        require_once __DIR__ . '/../common.php';
        $filePath = $filePath ?? FOOZ79_ROOT_DIR . '.env';
        if (file_exists($filePath)) {
            $env = parse_ini_file($filePath, true);
            foreach ($env as $key => $val) {
                $prefix = self::ENV_PREFIX . strtoupper($key);
                if (is_array($val)) {
                    foreach ($val as $k => $v) {
                        $item = $prefix . '_' . strtoupper($k);
                        putenv("$item=$v");
                    }
                } else {
                    putenv("$prefix=$val");
                }
            }
        }
    }
}
