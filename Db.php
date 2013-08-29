<?php

class Db {
    private static $server = 'localhost';
    private static $user = 'journal';
    private static $pass = 'fdfv45sdhju';
    private static $db = 'journal';
    private static $pdo = null;

    public static function getPdo()
    {
        if (!self::$pdo) self::$pdo = new PDO('mysql:host='.self::$server.';dbname='.self::$db, self::$user, self::$pass);
        return self::$pdo;
    }
}