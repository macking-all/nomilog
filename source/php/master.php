<?php

    require('dbconnect.php');
    $sql = 'select * from MUser';
    $list = '';
    //foreachは ループされる要素 as 単体
    try{
        $dbh = connectDB();
        foreach ($dbh->query($sql) as $row) {
            //selectしてきたもののidカラムとvar_nameカラムを結合してリストに出すよ
            $list .= '<li>'.$row['user_id'].':'.$row['user_name'].'</li>';
        }
    }catch(PDOException $e){
        //dieしてもいいんだけどね
        echo('DB接続時エラー:'.$e->getMessage());
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
</body>
</html>