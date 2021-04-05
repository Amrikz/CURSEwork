<?php


namespace App\Lib\Database;


interface DBInterface
{
    public static function GetConn();

    public function Query($sql);

    public function Fetch($dbh);

    public function StmtPrepare($sql);

    public function StmtExecute($params);

    public function AffectedRows();
}