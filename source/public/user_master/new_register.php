<?php

require '../dbconnect.php';
require '../functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

$user_name = filter_input(INPUT_POST, 'user_name');
$email = filter_input(INPUT_POST, 'email');
$email_flag = filter_input(INPUT_POST, 'email_flag');
if(isset($email_flag)){
    $email_flag = '1';
} else {
    $email_flag = '0';
}
$icon_image = filter_input(INPUT_POST, 'icon_image');
$password = filter_input(INPUT_POST, 'password');
$confirm_pass = filter_input(INPUT_POST, 'confirm_pass');
$admin_flag = filter_input(INPUT_POST, 'admin_flag');
if(isset($admin_flag)){
    $admin_flag = '1';
} else {
    $admin_flag = '0';
}

// エラーメッセージ
$err_msgs = '';

if(isset($_POST['register'])){

    // ユーザ名空チェック
    if(!$user_name){
        $errs[] = 'ユーザ名を入力してください';
    }
    if(!$email){
        $errs[] = 'メールアドレスを入力してください';
    } else if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email)){
        $errs[] = 'メールアドレスの形式で入力してください';
    } else if(!preg_match('/^.{0,100}$/i', $email)) {
        $errs[] = 'メールアドレスは100文字以内で入力してください';
    }

    // 画像ファイルかチェック
    // substr:文字列の一部分を返す, strrchr:文字列中に文字が最後に現れる場所を取得する    
    if(!empty($_FILES['icon_image']['name'])){
         // ファイル名をユニーク化
        $image_name = uniqid(mt_rand(), true);
         // アップロードされたファイルの拡張子を取得
        $image_name .= '.' . substr(strrchr($_FILES['icon_image']['name'], '.'), 1);
        
        $file = "images/$image_name";
        if(exif_imagetype($file)) {
            $errs[] = '画像ファイルをアップロードしてください';
        }
    } else {
        $image_name = 'default.png';
    }

    // パスワードルールチェック（英数字記号８文字以上３０文字以内）
    if(!preg_match('/\A(?=.*?[a-z])(?=.*?\d)(?=.*?[!-\/:-@[-`{-~])[!-~]{8,30}+\z/i', $password)){
        $errs[] = 'パスワードは半角英数字記号3種類、8文字以上30文字以内で設定してください';
    }
    // 確認用パスワードとの一致確認
    if($password !== $confirm_pass){
        $errs[] = 'パスワードが一致しません';
    }
    
    if(!isset($errs)){
        // imagesディレクトリにファイル保存
        move_uploaded_file($_FILES['icon_image']['tmp_name'], '../images/' . $image_name);

        $sql = 'insert into MUser (
                    user_name, email, email_flag, icon_image, password, admin_flag
                ) 
                values (
                    :user_name, :email, :email_flag, :icon_image, :password, :admin_flag
                )';

        $stmt = $dbs->prepare($sql);
        $stmt->bindValue('user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->bindValue('email_flag', $email_flag);
        $stmt->bindValue('icon_image', $image_name, PDO::PARAM_STR);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindValue('password', $password, PDO::PARAM_STR);
        $stmt->bindValue('admin_flag', $admin_flag);
        $stmt->bindValue('register_user', $_SESSION['USER_ID']);
        $stmt->execute();
        $dbs = null;

        header('Location: master.php');
    } else {
        foreach($errs as $err){
            $err_msgs .= '<li>'.$err.'</li>';
        }
    }
}

?>

<?php include('../common/_header.php'); ?>

<body>
    <main>
        <h1>新規ユーザ登録</h1>

        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
        <div id="contents">
            <form action="" method="post" enctype="multipart/form-data">
                <label for="user_name">ユーザ名</label>
                <input id="user_name" type="text" name="user_name" value="<?= $user_name; ?>">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" name="email" value="<?= $email; ?>">
                <label for="email_flag">メール通知を受け取る</label>
                <input id="email_flag" type="checkbox" name="email_flag">
                <label for="icon_img">アイコン画像</label>
                <input id="icon_img" type="file" name="icon_image">
                <label for="password">パスワード</label>
                <input id="password" type="password" name="password">
                <label for="confirm_pass">確認用パスワード</label>
                <input type="password" name="confirm_pass">
                <label for="admin_flag">管理者フラグ</label>
                <input id="admin_flag" type="checkbox" name="admin_flag">
                <input type="submit" value="登録" name="register">
                <input type="button" onclick="history.back()" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('../common/_footer.php'); ?>