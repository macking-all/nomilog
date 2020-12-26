<?php

namespace nlfw\config;

class daoConfig {
    public const SERVER_NAME = "nomilog_nldb_1";
    public const DB_NAME = "nomilog";
    public const DB_PORT = "3306";
    public const DSN = "mysql:host=".self::SERVER_NAME.";dbname=".self::DB_NAME.";port=".self::DB_PORT;
    public const DB_USER = "root";
    public const DB_PWD = "root";
}

?>