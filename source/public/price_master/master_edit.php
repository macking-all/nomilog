<?php
    
    //session_start();
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $price_id = $_POST['row-x'];

    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MPrice where price_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $price_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);
    } else if(isset($_POST['delete'])){
        $sql = 'update MPrice set delete_flag=1 where price_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $price_id;
        $stmt->execute($data);
        header('Location: master.php');
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>価格マスタ</title>

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
        <input type="hidden" name="price_id" value="<?= $record['price_id']; ?>">
        <label for="price_range">地域名：</label>
        <input type="text" name="price_range" id="price_range" value="<?= $record['price_range']; ?>"><br>
        <label for="register_user">登録者：</label>
        <input type="text" name="register_user" id="register_user" value="<?= $record['register_user']; ?>"><br>
        <label for="created">登録日時：</label>
        <input type="text" name="created" id="created" value="<?= $record['created']; ?>"><br>
        <label for="updated_user">更新者</label>
        <input type="text" name="updated_user" id="updated_user" value="<?= $record['updated_user']; ?>"><br>
        <label for="updated">更新日時：</label>
        <input type="text" name="updated" id="updated" value="<?= $record['updated']; ?>"><br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="更新" id="btn">
    </form>
    
    <!-- <span id="name-error-message">名前を入力してください</span>
    <span id="email-error-message">メールアドレスの形式で入力してください</span>
    <span id="pass-error-message">半角英数字8文字以上30文字以下で入力してください</span> -->

</body>
</html>

