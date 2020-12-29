<?php

    require 'dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    $sql = 'select * from MUser';
    $stmt = $dbs->query($sql);
    foreach ($stmt as $value){
        $records .= '<tr><th>'. $value['user_id'].'</th>'.'<th>'.$value['user_name'].'</th>'.'<th>'.$value['email'].'</th></tr>';
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
    <h1>ユーザマスタ</h1>
    <ul><?= $li ?></ul>

    <table>
    <tbody>
     <tr><th>id</th><th>ユーザ名</th><th>Eーメール</th></tr>
     <?= $records ?>
    </tbody>
    </table>
</body>
</html>