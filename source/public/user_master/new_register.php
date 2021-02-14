<?php

require '../dbconnect.php';
require '../functions.php';

$dbs = new Datebase();
$dbs->dbconnect();

$user_name = filter_input(INPUT_POST, 'user_name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$email_flag = filter_input(INPUT_POST, 'email_flag');
$icon_image = filter_input(INPUT_POST, 'icon_image');
$password = filter_input(INPUT_POST, 'password');
$admin_flag = filter_input(INPUT_POST, 'admin_flag');

// バリデーション処理を書く

if(isset($_POST['register'])){
    $sql = 'insert into MUser (user_name, email, email_flag, icon_image, password, admin_flag) values (?, ?, ?, ?, ?, ?)';

    $stmt = $dbs->prepare($sql);
    $data[] = $user_name;
    $data[] = $email;
    $data[] = $email_flag === null ? 0 : 1;
    $data[] = $icon_image;
    $data[] = password_hash($password, PASSWORD_DEFAULT);
    $data[] = $admin_flag === null ? 0 : 1;
    $stmt->execute($data);

    header('Location: master.php');
}
    
?>

<?php include('../common/_header.php'); ?>

<body>
    <main>
        <h1>新規ユーザ登録</h1>

        <div class="error-message">
            <ul>
                <li>エラーメッセージ表示枠テスト1</li>
                <li>エラーメッセージ表示枠テスト2</li>
            </ul>
        </div>
        
        <div id="contents">
            <form action="" method="post" name="new_form">
                <label for="user_name">表示名</label>
                <input id="user_name" type="text" name="user_name" value="">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" name="email" value="">
                <label for="email_flag">メール通知を受け取る</label>
                <input id="email_flag" type="checkbox" name="email_flag" value="">
                <label for="icon_img">アイコン画像</label>
                <input id="icon_img" type="file" name="icon_image">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password">
                <label for="confirm_pass">確認用パスワード</label>
                <input type="password" name="confirm_pass">
                <label for="email_flag">管理者フラグ</label>
                <input id="admin_flag" type="checkbox" name="admin_flag" value="">
                <input type="submit" value="登録" name="register">
                <input type="submit" onclick="" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('../common/_footer.php'); ?>