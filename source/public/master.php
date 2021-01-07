<?php

    session_start();

    require 'dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();
    //テーブル名は変数にしたい⇨マスタ管理画面からどのボタンが押されたかで、テーブル名を指定したい
    $sql = 'select * from MUser';
    
    //マスタの全レコードを取得する(全データだと多すぎるから、最初は何も表示しない方が良いのか・・・)
    $stmt = $dbs->query($sql);
    //tableだと、各レコードの編集と削除ボタンを押した際に判定ができないか？
    //編集または削除ボタンを押すと各レコードの編集画面に飛ぶ(URLクエリでID判定する？)
    foreach ($stmt as $value){
        $records .= '<tr><th>'. $value['user_id'].'</th>'.'<th>'.$value['user_name'].'</th>'.'<th>'.$value['email'].'</th><th><button><a href="input_do.php?id=">編集</a></button> <button><a href="delete.php">削除</a></button></th></tr>';
    }
?>

<!DOCTYPE html>
<html lang="ja_JP">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>呑みログ</title>
    <style>
     table{
         border: 1px solid #ccc;
         border-collapse: collapse;
     }
     table th{
        border: 1px solid #ccc;
        border-collapse: collapse;
     }
    </style>
</head>
<body>
    <h1><!-- 管理画面から選択されたマスタ名を入れる --></h1>

    <!-- マスタの中身を表示させる -->
    <table>
    <tbody>
     <tr><th>id</th><th>ユーザ名</th><th>Eーメール</th><th></th></tr>
     <?= $records ?>
    </tbody>
    </table>
</body>
</html>