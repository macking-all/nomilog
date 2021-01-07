<?php

    //URLクエリのIDのに一致するレコードのデータを編集する画面を表示する
    
    require 'dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    //URLパラメータを取得
    $id = $_REQUEST['id'];
    
    //該当するレコードを取得
    $sql = 'select * from MUser where id=?';
    $stmt = $dbs->prepare($sql);
    $stmt->execute(array($id));
    $stmt = $stmt->fetch();
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <!-- inputタグで表示？　id,ユーザ名,Eメールは最初から入れる -->
</body>
</html>