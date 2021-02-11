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
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="更新" id="btn">
    </form>
</body>
</html>

