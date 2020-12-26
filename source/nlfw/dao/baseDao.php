<?php
namespace nlfw\dao;

class baseDao {
    private $_conn;
    public function connect($dsn,$user,$pwd) {
        try {
            $_conn = new PDO($dsn,$user,$pwd);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public function disconnect() {
        $_conn = null;
    }

    public function select($sql) {
        $this->validateConnect();
        try {
            return $_conn->query($sql);
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function execute($sql) {
        $this->validateConnect();
        try {
            return $_conn->exec($sql);
        } catch(Exception $e) {
            throw $e;
        }
    }

    private function validateConnect() {
        if($_conn == null) throw new RuntimeException("DBに接続されていません");
    }
}

?>