<?php


namespace Bin\Framework\Lib\Database;


use Bin\Framework\Lib\Logging\Logger;
use Config\AppConfig;
use PDO;

class PdoDB implements DBInterface
{
    public static $conn = null;
    private $res;
    private $stmt;


    public function __construct()
    {
        $host       = AppConfig::DBHOST;
        $db         = AppConfig::DBNAME;
        $charset    = AppConfig::DBCHARSET;
        $dsn        = "mysql:host=$host;dbname=$db;charset=$charset";

        $opt = [
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES      => false,
        ];

        $conn = new PDO($dsn, AppConfig::DBLOGIN, AppConfig::DBPASS, $opt);

        if (!$conn) {
            Logger::Error(__METHOD__, $conn->errorInfo());
            makeError("Database connection error!");
        }

        self::$conn = $conn;
        return $conn;
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
        if (!self::$conn)
            self::getConn();

        $this->res = null;
        $this->stmt = null;

        Logger::Info(__METHOD__, $sql);
        $res = self::$conn->query($sql);
        $this->res = $res;
        return $res;
    }


    public function Fetch($dbh = null)
    {
        if (!self::$conn || (!$this->res && !$dbh)) {
            makeError("Nothing to Fetch!");
        }
        if (is_null($dbh)) $dbh = $this->res;
        if ($this->res->columnCount()) $data = $dbh->fetchAll();
        $this->res->closeCursor();
        return $data;
    }


    public function StmtPrepare($sql)
    {
        if (!self::$conn)
            self::getConn();

        $this->res = null;
        $this->stmt = null;

        Logger::Info(__METHOD__, $sql);
        $this->stmt = self::$conn->prepare($sql);
        return $this->stmt;
    }


    public function StmtExecute($params)
    {
        if (!self::$conn || !$this->stmt) {
            makeError("Nothing to Execute!");
        }

        if ($params) Logger::Info(__METHOD__, "Params: ".arrayDataToStr($params));
        $res = $this->stmt->execute($params);
        $this->res = &$this->stmt;
        return $res;
    }


    public function AffectedRows()
    {
        if ($this->stmt) return $this->stmt->rowCount();
        return false;
    }
}