<?php

    //session_start(); 

    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

        $serchWord = $_POST['serch_word'];
        $serchWord = $serchWord . '%';
        $sql = 'select
                    st1.cook_id,
                    st1.cook_name,
                    st2.user_name as register_user,
                    st1.created,
                    st3.user_name as updated_user,
                    st1.updated,
                    st1.delete_flag
                from 
                    MCook st1
                    left join MUser st2 on st1.register_user = st2.user_id
                    left join MUser st3 on st1.updated_user = st3.user_id';


        $data = null;
        if(isset($_POST['serch'])){
            $data = array($serchWord);
            $sql .= ' where st1.cook_name like ?';
        }
        $stmt = $dbs->prepare($sql);
        //マスタの全レコードを取得する
        //$stmt = $dbs->query($sql);
        $stmt->execute($data);

        $tableHeaderHtml = '<tr><th>料理ジャンル名</th><th>登録者</th><th>登録日時</th><th>更新者</th><th>更新日時</th><th>削除フラグ</th><th>ボタン</th>';
        foreach ($stmt as $value){
            $records .= '<tr><td>'. $value['cook_name'] . '</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td>'.$value['delete_flag'].'</td><td><form action="master_edit.php" method="post"><button type="submit" name="edit">編集</button><button type="submit" name="delete" onclick="return popup();">削除</button><input type="hidden" name="row-x" value="'. $value['cook_id'].'"></form></td></tr>';
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
        width: 90%;
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
        //レコード削除の確認
        function popup(){
            return confirm('このマスタを削除しもよろしいですか?');
        }
    </script>

    <h1>地域マスタ<!-- 管理画面から選択されたマスタ名を入れる --></h1>

    <form action="" method="post" id="serch">
        <input type="text" name="serch_word" placeholder="料理ジャンル名">
        <input type="submit" name="serch" value="検索">
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