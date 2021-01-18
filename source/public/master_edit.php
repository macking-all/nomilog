<?php
    
    require 'dbconnect.php';
    $dbs = new Datebase();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $user_id = $_POST['row-x'];
    //対象のユーザIDのレコードを取得
    $sql = 'select * from MUser where user_id=?';
    $stmt = $dbs->prepare($sql);
    $stmt->execute(array($user_id));
    $data = $stmt->fetch();
    
    
    if(isset($_POST['edit'])){
        echo '編集ボタンが押されたよ';
        echo $data['user_name'];
    } else if(isset($_POST['delete'])){
        echo '削除ボタンが押されたよ';
    }

?>

