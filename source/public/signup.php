<?php

require_once './dbconnect.php';
require_once './functions.php';

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

// エラーメッセージ格納
$err_msgs = '';

if(isset($_POST['register'])){

    // ユーザ名空チェック
    if(!$user_name){
        $errs[] = 'ユーザ名を入力してください';
    }
    // Eメール空チェック&形式チェック
    if(!$email){
        $errs[] = 'メールアドレスを入力してください';
    } else if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email)){
        $errs[] = 'メールアドレスの形式で入力してください';
    } else if(!preg_match('/^.{0,100}$/i', $email)) {
        $errs[] = 'メールアドレスは100文字以内で入力してください';
    }

    // Eメール重複登録チェック
    $sql = 'select count(*) as cnt from MUser where email = :email';
    $stmt = $dbs->prepare($sql);
    $stmt->bindValue('email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $email_exist = $stmt->fetch();

    if($email_exist[0] === '1'){
        $errs[] = '入力したメールアドレスはすでに使用されています';
    }

    // 画像ファイルかチェック
    //substr:文字列の一部分を返す, strrchr:文字列中に文字が最後に現れる場所を取得する
    $image_name = $_FILES['icon_image']['name'];

    if(!empty($image_name)){
        
         // アップロードされたファイルの拡張子を取得
        $file_type .= '.' . substr(strrchr($image_name, '.'), 1);
        if(exif_imagetype($file_type)) {
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
    
    // エラーがなかったらユーザの登録処理開始
    if(!isset($errs)){

        // ユーザ情報登録
        $sql = 'insert into MUser (
            user_name, email, email_flag, icon_image, password, admin_flag
        ) 
        values (
            :user_name, :email, :email_flag, :icon_image, :password, :admin_flag
        )';
        
        // 画像情報登録のためのユーザID取得
        $sql2 = 'select user_id from MUser where email = :email';

        // 画像ファイルのパスを登録
        $sql3 ='insert into MUser (icon_image) values(:icon_image)';
        
        try{
            // トランザクション開始
            $dbs->beginTransaction();
            
            // 入力されたユーザ情報をDBへ登録
            $stmt = $dbs->prepare($sql);
            $stmt->bindValue('user_name', $user_name, PDO::PARAM_STR);
            $stmt->bindValue('email', $email, PDO::PARAM_STR);
            $stmt->bindValue('email_flag', $email_flag);
            $stmt->bindValue('icon_image', $image_name, PDO::PARAM_STR);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindValue('password', $password, PDO::PARAM_STR);
            $stmt->bindValue('admin_flag', $admin_flag);
            $stmt->execute();

            // 12345678@test

            // 画像保存フォルダ作成のためにユーザID取得
            $stmt2 = $dbs->prepare($sql2);
            $stmt2->bindValue('email', $email, PDO::PARAM_STR);
            $stmt2->execute();
            $userId = $stmt2->fetch(PDO::FETCH_ASSOC);
    
            // ユーザIDのフォルダ名定義　
            $images_structure = 'images/' . $userId['user_id'];
            
            // 画像がアップロードされていればフォルダを作成する
            if($image_name !== 'default.png'){
                mkdir($images_structure, 0777);
            }

            /* memo
             * default.pngはここでは指定せずに、_header.phpでicon_imageが空だった時にcase句で値を指定するようにする
             */


            // アップロードされた画像をユーザIDフォルダに移動
            move_uploaded_file($_FILES['icon_image']['tmp_name'], $images_structure . '/' . $image_name);
            
            $dbs->commit();

            header('Location: post_list.php');

        } catch(PDOException $e) {
            $dbs->rollBack();
            echo $e->getMessage();
	        exit();
        }

        $dbs = null;
        exit;
    } else {
        foreach($errs as $err){
            $err_msgs .= '<li>'.$err.'</li>';
        }
    }
}

?>

<?php include('./common/_header.php'); ?>

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
                <input type="submit" value="登録" name="register">
                <input type="button" onclick="history.back()" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('./common/_footer.php'); ?>