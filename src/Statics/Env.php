<?php

declare(strict_types=1);

namespace FooZ79\Statics;

class Env
{
    private const ENV_PREFIX = '_FOOZ79';

    public static function get(string $name, $default = null)
    {
        if (!isset($_ENV[self::ENV_PREFIX])) self::loadFile();

        $result = $_ENV[self::ENV_PREFIX][strtoupper(str_replace('.', '_', $name))] ?? false;
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

    public static function getString(string $name, string $default = ''): string
    {
        return strval(self::get($name, $default));
    }

    public static function getInt(string $name, int $default = 0): int
    {
        return intval(self::get($name, $default));
    }

    public static function getFloat(string $name, float $default = 0, int $precision = 4): float
    {
        return round(self::get($name, $default), $precision);
    }

    public static function getBool(string $name, bool $default = false): bool
    {
        return boolval(self::get($name, $default));
    }

    public static function getArray(string $name, array $default = [], string $separator = ',', array $replace_pairs = null): array
    {
        if (is_null($replace_pairs)) {
            $replace_pairs = [
                ' ' => ''
            ];
        }
        return explode($separator, strtr(self::get($name, $default), $replace_pairs));
    }

    public static function set(string $name, $value)
    {
        $k = strtoupper(str_replace('.', '_', $name));
        $_ENV[self::ENV_PREFIX][$k] = $value;
    }

    public static function loadFile($filePath = null, string $withName = null): void
    {
        require_once __DIR__ . '/../common.php';
        $filePath = $filePath ?? FOOZ79_ROOT_DIR . '.env';
        if (file_exists($filePath)) { // parse .env
            self::parse_file($filePath);
            if ($withName) { // parse .env.${withName}
                $filePath .= '.' . $_ENV[self::ENV_PREFIX]['APP_ENV'];
                if (file_exists($filePath)) {
                    self::parse_file($filePath);
                }
            }
        } else {
            throw new \Exception('env file: ' . $filePath . ' not exist.');
        }
    }

    private static function parse_file(string $filePath): void
    {
        $ini_array = parse_ini_file($filePath, true);
        foreach ($ini_array as $key => $val) {
            $key = strtoupper($key);
            if (is_array($val)) {
                foreach ($val as $k => $v) {
                    $k = $key . '_' . $k;
                    self::set($k, $v);
                }
            } else {
                self::set($key, $val);
            }
        }
    }
}
