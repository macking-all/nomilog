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

<?php include('../common/_header.php'); ?>

<body>
    <script>
        //レコード削除の確認
        function popup(){
            return confirm('このマスタを削除しもよろしいですか?');
        }
    </script>

<mian>    
    <h1>料理マスタ</h1>

    <div class="error-message">
      <ul>
        <li>エラーメッセージ表示枠テスト1</li>
        <li>エラーメッセージ表示枠テスト2</li>
      </ul>
    </div>

    <div id="search">
        <form action="" method="post" id="serch">
            <label for="coook_name">料理ジャンル名</label>
            <input id="coook_name" type="text" name="serch_word" placeholder="料理ジャンル名">
            <input type="submit" name="serch" value="検索">
        </form>
    </div>
    <div id="master_lists">
      <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
      <!-- マスタ一覧表示-->
        <table>
            <tbody>
                <?= $tableHeaderHtml ?>
                <?= $records ?>
            </tbody>
        </table>
    <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
    </div>
  </main>
<?php include('../common/_footer.php'); ?>