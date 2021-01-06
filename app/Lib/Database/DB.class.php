<?php


namespace App\Lib\Database;


use Config\AppConfig;
use mysqli;

class DB
{
    public static $conn = null;


    public function __construct()
    {
        $conn = new mysqli(AppConfig::DBHOST, AppConfig::DBLOGIN, AppConfig::DBPASS, AppConfig::DBNAME);
        $conn->set_charset('utf8');
        if (!$conn) {
            die("database connect error!");
        }
        $this->conn = $conn;
    }


    public static function getConn()
    {
        if (is_null(self::$conn))
        {
            return new self;
        }
        return self::$conn;
    }


    public function query($sql)
    {
        $res = $this->conn->query($sql);
        return $res;
    }


    public static function fetch($dbh)
    {
        return $dbh->fetch_all($resulttype = MYSQLI_ASSOC);
    }


    public static function static_request($sql)
    {
        if (!self::$conn) {
            self::$conn = self::getConn();
        }
        return self::$conn->fetch(self::$conn->query($sql));
    }


    public static function static_query($sql)
    {
        if (!self::$conn) {
            self::$conn = self::getConn();
        }
        $res = self::$conn->query($sql);
        return $res;
    }
}