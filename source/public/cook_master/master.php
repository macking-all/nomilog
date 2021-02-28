<?php
    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

        $serchWord = $_POST['serch_word'];
        $sql_serchWord = '%' . $serchWord . '%';
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
            $data = array($sql_serchWord);
            $sql .= ' where st1.cook_name like ?';
        }
        $stmt = $dbs->prepare($sql);
        $stmt->execute($data);

        foreach ($stmt as $value){
            $setBackgroundColor = $value['delete_flag'] === '1' ? ' class="table-restoration-color"' : '';
            $setButton = $value['delete_flag'] === '1' ? '<button type="submit" name="restore" onclick="return popup2()";>復元</button>' : '<button type="submit" name="edit">編集</button><button type="submit" name="delete" onclick="return popup();">削除</button>';
            $records .= '<tr' . $setBackgroundColor .'><td>'. $value['cook_name'] . '</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td>'.$value['delete_flag'].'</td><td><form action="master_edit.php" method="post">'. $setButton .'<input type="hidden" name="cook_id" value="'. $value['cook_id'].'"></form></td></tr>';
        }
?>

<?php include('../common/_header.php'); ?>

<body>
    <script>
        //レコード削除の確認
        function popup(){
            return confirm('このマスタを削除しもよろしいですか?');
        }
        function popup2(){
            return confirm('このマスタを復元してもよろしいですか?');
        }
    </script>

<mian>    
    <h1>料理マスタ</h1>

    <div id="search">
        <form action="" method="post" id="serch">
            <label for="coook_name">料理ジャンル名</label>
            <input id="coook_name" type="text" name="serch_word" value="<?= $serchWord ?>" placeholder="料理ジャンル名">
            <input type="submit" name="serch" value="検索">
        </form>
    </div>
    <div id="contents">
      <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
      <!-- マスタ一覧表示-->
        <table>
            <tbody>
              <tr>
                <th>料理ジャンル名</th>
                <th>登録者</th>
                <th>登録日時</th>
                <th>更新者</th>
                <th>更新日時</th>
                <th>削除フラグ</th>
                <th>ボタン</th>
              </tr>
                <?= $records ?>
            </tbody>
        </table>
    <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
    </div>
  </main>
<?php include('../common/_footer.php'); ?>