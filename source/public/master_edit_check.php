<?php 

    require 'functions.php';

    $user_name = h($_POST['user_name']);
    $email = h($_POST['email']);
    $email_flag = $_POST['email_flag'];
    $passwaord = h($_POST['password']);
    $confirm_pass = h($_POST['confirm_pass']);
    $icon_image = $_POST['icon_image'];

    $errorMessage = '';

    if($user_name === '')
    {
        $errorMessage .= 'ユーザ名を入力してください' . '<br>';
    } 

    if($email === '')
    {
        $errorMessage .= 'メールアドレスを入力してください' . '<br>';
    }

    if($password === '')
    {
        $errorMessage .= 'パスワードを入力してください' . '<br>';
    }

    if($password !== $confirm_pass)
    {
        $errorMessage .= 'パスワードが一致しません' . '<br>';
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?= $errorMessage ?>
</body>
</html>