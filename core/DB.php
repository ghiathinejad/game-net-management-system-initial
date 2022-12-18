<?php

namespace Core;

use Medoo\Medoo;

class DB
{
    private static $db;

    public static function get(): Medoo
    {
        if (!is_null(static::$db)) {
            return static::$db;
        }

        static::$db = new Medoo([
            'type' => 'mysql',
            'host' => Config::get('DB_HOST'),
            'database' => Config::get('DB_NAME'),
            'username' => Config::get('DB_USERNAME'),
            'password' => Config::get('DB_PASSWORD'),
        ]);

        return static::$db;
    }
}
