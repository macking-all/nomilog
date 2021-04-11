<?php

class Database
{
    const user = 'root';
    const pass = 'root';
    const dsn = 'mysql:host=nomilog_nldb_1;dbname=nomilog;port=3306';
    //protectedは継承先から呼べる
    protected $dbh;

    public function dbconnect(){
        $this->dbh = new PDO($this::dsn, $this::user, $this::pass);
    }

    public function beginTransaction(){
        $this->dbh->beginTransaction();
    }

    public function commit(){
        $this->dbh->commit();
    }

    public function rollback(){
        $this->dbh->rollback();
    }

    public function query($sql){
        if($this->dbh === null){
            throw new Exception('接続されてません');
        }
        return $this->dbh->query($sql);
    }

    public function prepare($sql){
        return $this->dbh->prepare($sql);
    }

    //DBへの接続を切断する
    public function disdbconnect(){
        $this->dbh = null;
    }
}

// function connectDB(){
//     //接続設定
//     $dsn = 'mysql:host=nomilog_nldb_1;dbname=nomilog;port=3306';
//     $user = 'root';
//     $password = 'root';

//     try{
//         //接続する
//         //$dbh = new PDO($dsn, $user, $password, array( PDO::ATTR_PERSISTENT => false));
//         return new PDO($dsn, $user, $password);
//     }catch (PDOException $e){
//         //dieしてもいいんだけどね
//         echo('DB接続時エラー:'.$e->getMessage());
//     }finally {
//         //まあ多分ここで閉じとけばいいと思う
//         //実際のコードだとこのあたりは共通化して触れないようになると思われるけど
//         $dbh=null;
//     }
// }

// echo var_dump(); 変数の内容を整形する
// クラス化する
// 接続
// クエリを投げる
// 切断

?>
