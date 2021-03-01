<?php

require './dbconnect.php';
require './functions.php';

session_start();
$errs = [];

$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errs .= '入力された値が不正です';
    return false;
}

$dbs = new Database();
$dbs->dbconnect();

$sql = 'select * from MUser where email = ?';
$stmt = $dbs->prepare($sql);
$stmt->execute(array($email));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($row['email'])){
    $errs .= 'メールアドレス又はパスワードが間違っています。';
    return false;
}

if(password_verify($password, $row['password'])){
    session_regenerate_id(true);
    $_SESSION['EMAIL'] = $row['email'];
    echo 'ログインしました' .'<br>';
    echo 'ようこそ' .  h($_SESSION['EMAIL']) . "さん<br>";
    //header('Location: post.php');
} else {
    echo 'メールアドレス又はパスワードが間違っています。';
    return false;
}

foreach($errs as $err){
    $err_msg .= '<li>' . $err . '</li>';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="error-message">
        <ul>
            <?= $err_msg; ?>
        </ul>
    </div>
</body>
</html>