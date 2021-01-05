<?php
namespace nlfw\dao;

class baseDao {
    protected $_conn;
    protected function connect($dsn,$user,$pwd) {
        try {
            $this->_conn = new PDO($dsn,$user,$pwd);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    protected function disconnect() {
        $this->_conn = null;
    }

    protected function select($sql,$params) {
        $this->validateConnect();
        try {
            $stmt = $this->_conn->prepare($sql);
            if($stmt->execute($params)) {
                return $stmt;
            }
        } catch(Exception $e) {
            throw $e;
        }
    }

    protected function execute($sql,$params) {
        $this->validateConnect();
        try {
            $stmt = $this->_conn->prepare($sql);
            $i = 1;
            foreach($params as $p) {
                $stmt->bindParam($i++,$p);
            }
            if($stmt->execute()) {
                return $stmt;
            }
        } catch(Exception $e) {
            throw $e;
        }
    }

    private function validateConnect() {
        if($this->_conn == null) throw new RuntimeException("DBに接続されていません");
    }
}

?>