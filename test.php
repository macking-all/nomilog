<?php
$dsn = 'mysql:dbname=nomilog;host=localhost';
$user = 'nomilog';
$password = 'nomilogdbpassword';

try{
    $dbh = new PDO($dsn, $user, $password);
//    $dbh->query('SET NAMES utf8');

    $sql = 'select * from test_table';
    $list = '';
    foreach ($dbh->query($sql) as $row) {
        $list .= '<li>'.$row['id'].':'.$row['var_name'].'</li>';
    }    
}catch (PDOException $e){
    echo('Error:'.$e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja_JP">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?=$title?></h1>
    <ul><?=$list?></ul>
</body>
</html>