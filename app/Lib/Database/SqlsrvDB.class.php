<?php


namespace App\Lib\Database;


use App\Lib\Logging\Logger;
use Config\AppConfig;

class SqlsrvDB implements DBInterface
{
    public static $conn = null;
    private $res;
    private $stmt;


    public function __construct()
    {
        $host       = AppConfig::DBHOST;
        $db         = AppConfig::DBNAME;
        $login      = AppConfig::DBLOGIN;
        $pass       = AppConfig::DBPASS;
        $charset    = AppConfig::DBCHARSET;

        $connectionInfo     = [
            'Database'      => $db,
            'CharacterSet'  => $charset
        ];

        if ($login) $connectionInfo['UID']  = $login;
        if ($pass)  $connectionInfo['PWD']  = $pass;


        $conn = sqlsrv_connect($host, $connectionInfo);

        if (!$conn) {
            Logger::Error(__METHOD__, var_export(sqlsrv_errors(),true));
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
        if (!self::$conn) {
            self::getConn();
        }
        Logger::Info(__METHOD__, $sql);
        $res = sqlsrv_query(self::$conn, $sql);
        if (sqlsrv_errors())
        {
            Logger::Error(__METHOD__, var_export(sqlsrv_errors(),true));
            makeError("Query error!");
        }
        $this->res = $res;
        return $res;
    }


    public function Fetch($dbh = null)
    {
        if (!self::$conn || (!$this->res && !$dbh)) {
            makeError("Nothing to Fetch!");
        }
        if (is_null($dbh)) $dbh = $this->res;

        $i = 0;
        do
        {
            $row = sqlsrv_fetch_array( $dbh, SQLSRV_FETCH_ASSOC);
            if ($row)
            {
                $res[] = $row;
                $i++;
            }
        }
        while ($row);

        $this->res = null;

        return $res;
    }


    public function StmtPrepare($sql)
    {
        if (!self::$conn) {
            self::getConn();
        }
        Logger::Info(__METHOD__, $sql);
        $this->stmt = $sql;
        return $this->stmt;
    }


    public function StmtExecute($params)
    {
        if (!self::$conn || !$this->stmt) {
            makeError("Nothing to Execute!");
        }

        if ($params) Logger::Info(__METHOD__, "Params: ".arrayDataToStr($params));

        $this->stmt = sqlsrv_prepare(self::$conn, $this->stmt, $params);
        sqlsrv_execute($this->stmt);
        if (sqlsrv_errors())
        {
            Logger::Error(__METHOD__, var_export(sqlsrv_errors(),true));
            makeError("Query error!");
        }
        $this->res = $this->stmt;
        return $this->stmt;
    }


    public function AffectedRows()
    {
        if ($this->stmt) return sqlsrv_rows_affected($this->stmt);
        return false;
    }
}