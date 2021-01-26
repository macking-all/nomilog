<?php
    
    require 'dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $user_id = $_POST['row-x'];

    // function setDeleteFlag(){
    //     $sql = 'update MUser set delete_flag=1 where user_id=?';
    //     $stmt = $dbs->prepare($sql);
    //     $data[] = $user_id;
    //     $stmt->execute($data);
    //     header('Location: master.php');
    // }

    function editForm(){
        
    }
    
    if(isset($_POST['edit'])){
        
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MUser where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $record['user_name'];

        
    } else if(isset($_POST['delete'])){
        $sql = 'update MUser set delete_flag=0 where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        $message = 'アカウントを削除しました。';
        //header('Location: master.php');
        $backButton = '<a href="master.php">';
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* エラーメッセージの非表示 */
        #name-error-message {
            display: none;
        }
        #email-error-message {
            display: none;
        }
        #pass-error-message {
            display: none;
        }
    </style>
</head>
<body>
    <?= $message ?><br>
    <form action="master_edit_check.php" method="post" id="form">
        <input type="hidden" value="<?= $user_id ?>">
        <label for="user_name">ユーザ名前：</label>
        <input type="text" name="user_name" id="user_name" value="<?= $record['user_name']; ?>"><br>
        <label for="email">メールアドレス：</label>
        <input type="text" name="email" id="email" value="<?= $record['email']; ?>"><br>
        <label for="email_flag">メール通知を受け取る：</label>
        <input type="checkbox" name="email_flag" id="email_flag" value="<?= $record['email_flag']; ?>"><br>
        <!--
            <label for="password">パスワード：</label>
            <input type="password" name="password" id="password" value=""><br>
            
            <label for="confirm_pass">確認用パスワード：</label>
            <input type="password" name="confirm_pass" id="confirm_pass" value=""><br>
        -->
        <label for="icon_image">アイコン画像：</label>
        <input type="file" name="icon_image" id="icon_image" value="<?= $record['icon_image']; ?>"><br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="更新" id="btn">
    </form>
    
    <span id="name-error-message">名前を入力してください</span>
    <span id="email-error-message">メールアドレスの形式で入力してください</span>
    <span id="pass-error-message">半角英数字8文字以上30文字以下で入力してください</span>

    <script src="js/validate.js"></script>
</body>
</html>

