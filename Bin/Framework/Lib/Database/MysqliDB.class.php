<?php


namespace Bin\Framework\Lib\Database;


use Bin\Framework\Lib\Logging\Logger;
use Config\AppConfig;
use mysqli;

class MysqliDB /*implements DBInterface*/
{
    public static $conn = null;
    private $res;


    public function __construct()
    {
        $conn = new mysqli(AppConfig::DBHOST, AppConfig::DBLOGIN, AppConfig::DBPASS, AppConfig::DBNAME);
        $conn->set_charset(AppConfig::DBCHARSET);
        if (!$conn) {
            Logger::Error(__METHOD__, $conn->error);
            makeError("Database connection error!");
        }
        self::$conn = $conn;
    }


    private function sql($sql)
    {
        $res = self::$conn->query($sql);
        Logger::Info(__METHOD__, $sql);
        if (self::$conn->error) Logger::Error(__METHOD__, "Query error: ".self::$conn->error);
        $this->res = $res;
        return $res;
    }


    public static function getConn()
    {
        if (is_null(self::$conn))
        {
            return new self;
        }
        return self::$conn;
    }


    public function Query($sql)
    {
        if (!self::$conn) {
            self::getConn();
        }
        $res = $this->sql($sql);
        return $res;
    }


    public function Fetch($dbh = null)
    {
        if (!self::$conn) {
            self::getConn();
        }
        if (is_null($dbh)) $dbh = $this->res;
        return $dbh->fetch_all($resulttype = MYSQLI_ASSOC);
    }
}