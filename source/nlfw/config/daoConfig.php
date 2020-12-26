<?php

namespace nlfw\config;

class daoConfig {
    public const SERVER_NAME = "nomilog_nldb_1";
    public const DSN = "mysql:host=".self::SERVER_NAME.";dbname=nomilog;port=3306";
    public const DB_USER = "root";
    public const DB_PWD = "root";
}

?>