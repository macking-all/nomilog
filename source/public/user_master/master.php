<?php

    //session_start();

    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Datebase();
    $dbs->dbconnect();
    //テーブル名は変数にしたい⇨マスタ管理画面からどのボタンが押されたかで、テーブル名を指定したい
    $sql = 'select * from MUser';
    
    //マスタの全レコードを取得する
    $stmt = $dbs->query($sql);
    $serchName = $_POST['serch_name'];
    $serchEmail = $_POST['serch_email'];
    $serchFlag = $_POST['serch_flag'];
    
    $keywords = [$serchName, $serchEmail, $serchFlag];
    // $serchName = filter_input(INPUT_POST, 'serch_name');
    // $serchEmail = filter_input(INPUT_POST, 'serch_email');
    // $serchFlag = filter_input(INPUT_POST, 'serch_flag');

    foreach($keywords as $keyword){
        $values[] = '%' . $keyword . '%';
    }

    $sql = 'select * from MUser';
    $sql = "SELECT * FROM MUser WHERE ((user_name LIKE ?) AND (email LIKE ? )";
    $values[] = null;
    //$data = null;
    if(isset($_POST['serch'])){
        // $data = array($serchName, $serchEmail, $serchFlag);
        // $sql .= ' where user_name like ? OR email like ? OR admin_flag ?';
        $sql = 'select * from MUser';
    $sql = "SELECT * FROM MUser WHERE ((user_name LIKE ?) AND (email LIKE ? )";

    }
    $stmt = $dbs->prepare($sql);
    //マスタの全レコードを取得する
    //$stmt = $dbs->query($sql);
    $stmt->execute($values);
    
    $tableHeaderHtml = '<tr><th>表示名</th><th>メールアドレス</th><th>メール通知</th><th>管理者フラグ</th><th>登録者</th><th>登録日時</th><th>更新者</th><th>更新日時</th><th>最終ログイン日時</th><th>削除フラグ</th><th>ボタン</th>';
    foreach ($stmt as $value){
        $records .= '<tr><td>'. $value['user_name'] . '</td><td>'.$value['email'].'</td><td>'.$value['email_flag'].'</td><td>'.$value['admin_flag'].'</td><td>'.$value['register_name'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_name'].'</td><td>'.$value['updated'].'</td><td>' . $value['last_login'] . '</td><td>' . $value['delete_flag'] . '</td><td><form action="u_master_edit.php" method="post"><button type="submit" name="edit">編集</button><button type="submit" name="delete" onclick="return popup();">削除</button><input type="hidden" name="row-x" value="'. $value['user_id'].'"></form></td></tr>';
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>呑みログ</title>
    <style>

    h1{
        text-align: center;
    }
     table{
        border: 1px solid #ccc;
        border-collapse: collapse;
        width: 95%;
        margin: 0 auto;
     }
     table th{
        border: 1px solid #ccc;
        border-collapse: collapse;
        padding: 5px;
        background-color: #6495ed;
     }

     table td{
        border: 1px solid #ccc;
        border-collapse: collapse;
        padding: 5px;
     }

     button{
        margin-left: 5px;
     }
    </style>
</head>
<body>
    <script>
        function popup(){
            return confirm('アカウントを削除しもよろしいですか?');
        }
    </script>

    
    <h1>ユーザマスタ<!-- 管理画面から選択されたマスタ名を入れる --></h1>
    <form action="" method="post">
        <input type="text" name="serch_name">
        <input type="text" name="serch_email">
        <input type="text" name="serch_flag">
        <input type="submit" value="検索" name="serch">
    </form>

    <!-- マスタの中身を表示させる -->
    <table>
    <tbody>
     <?= $tableHeaderHtml ?>
     <?= $records ?>
    </tbody>
    </table>
</body>
</html>