<?php
    
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $user_id = $_POST['row-x'];

    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MUser where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $record['user_name'];
        
    } else if(isset($_POST['delete'])){
        $sql = 'update MUser set delete_flag=1 where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        header('Location: master.php');
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
    
    <form action="master_edit_check.php" method="post" id="form">
        <input type="hidden" name="user_id" value="<?= $record['user_id']; ?>">
        <label for="user_name">ユーザ名前：</label>
        <input type="text" name="user_name" id="user_name" value="<?= $record['user_name']; ?>"><br>
        <label for="email">メールアドレス：</label>
        <input type="text" name="email" id="email" value="<?= $record['email']; ?>"><br>
        
        <label for="email_flag">メール通知を受け取る：</label>
        <input type="checkbox" name="email_flag" <?= $record['email_flag'] === '1' ? 'checked="checked"' : '';?> id="email_flag" value="<?= $record['email_flag']; ?>"><br>
        <label for="admin_flag">管理者フラグ</label>
        <input type="checkbox" <?= $record['admin_flag'] === '1' ? 'checked="checked"' : '';?> name="admin_flag" id="admin_flag" value="<?= $record['admin_flag']; ?>"><br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="更新" id="btn">
    </form>

</body>
</html>

