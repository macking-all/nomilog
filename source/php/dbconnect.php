<?php
//接続設定
$dsn = 'mysql:host=nomilog_nldb_1;dbname=nomilog;port=3306';
$user = 'root';
$password = 'root';

try{
    //接続する
    //$dbh = new PDO($dsn, $user, $password, array( PDO::ATTR_PERSISTENT => false));
    $dbh = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    //dieしてもいいんだけどね
    echo('DB接続時エラー:'.$e->getMessage());
}finally {
    //まあ多分ここで閉じとけばいいと思う
    //実際のコードだとこのあたりは共通化して触れないようになると思われるけど
    $dbh=null;
}
?>
