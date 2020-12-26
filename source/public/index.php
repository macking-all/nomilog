<?php
//接続設定
$dsn = 'mysql:host=nomilog_nldb_1;dbname=nomilog;port=3306';
$user = 'root';
$password = 'root';

try{
    $title = 'Test';

    //接続する
    //$dbh = new PDO($dsn, $user, $password, array( PDO::ATTR_PERSISTENT => false));
    $dbh = new PDO($dsn, $user, $password);

    $sql = 'select * from MUser';
    $list = '';
    //foreachは ループされる要素 as 単体
    foreach ($dbh->query($sql) as $row) {
        //selectしてきたもののidカラムとvar_nameカラムを結合してリストに出すよ
        $list .= '<li>'.$row['user_id'].':'.$row['user_name'].'</li>';
    }
    
    
}catch (PDOException $e){
    //dieしてもいいんだけどね
    echo('Error:'.$e->getMessage());
}finally {
    //まあ多分ここで閉じとけばいいと思う
    //実際のコードだとこのあたりは共通化して触れないようになると思われるけど
    $dbh=null;
}
?>

<!DOCTYPE html>
<html lang="ja_JP">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>呑みログ</title>
</head>
<body>
    <h1><?=$title?></h1>
    <ul><?=$list?></ul>
    <?php phpinfo();?>
</body>
</html>