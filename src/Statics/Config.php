<?php

declare(strict_types=1);

namespace FooZ79\Statics;

class Config
{
    private static $packageName;
    private static $config;

    public static function get(string $name)
    {
        $keys = explode('.', $name);
        $fileName = $keys[0];
        if (!isset(self::$config[$fileName]) || !is_array(self::$config[$fileName])) {
            self::loadFile($fileName);
        }
        $tree = self::tree($keys);
        return self::treeValue($tree, self::$config);
    }

    public static function setPackageName(string $packageName): void
    {
        if ($packageName) {
            self::$packageName = $packageName;
        } else {
            throw new \Exception('packageName is empty');
        }
    }

    private static function loadFile(string $fileName): void
    {
        require_once __DIR__ . '/../common.php';

        $configName = $fileName . '.php';
        if (isset(self::$packageName)) {
            $configPath = FOOZ79_CONFIG_DIR . DIRECTORY_SEPARATOR . $configName;
        } else {
            $packageConfig = FOOZ79_CONFIG_DIR . 'package' . DIRECTORY_SEPARATOR . self::$packageName . DIRECTORY_SEPARATOR . $configName;
            if (file_exists($packageConfig)) {
                $configPath = $packageConfig;
            }
        }
        self::$config[$fileName] = include $configPath;
    }

    private static function tree(array $keys, array &$tree = [], $value = null): array
    {
        $firstKey = array_key_first($keys);
        $key = $keys[$firstKey];
        unset($keys[$firstKey]);
        if (count($keys) > 0) {
            $tree[$key] = $tree[$key] ?? [];
            self::tree($keys, $tree[$key], $value);
        } else {
            $tree[$key] = $value;
        }
        return $tree ?? [];
    }

    private static function treeValue(array $tree, array $value)
    {
        foreach ($tree as $k => $v) {
            if (is_array($v)) {
                return self::treeValue($v, $value[$k]);
            } else {
                return $value[$k];
            }
        }
    }
}
