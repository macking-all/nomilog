<?php
    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

        $serchWord = $_POST['serch_word'];
        $serchWord =  '%' . $serchWord . '%';

        $sql = 'select
                    st1.area_id,
                    st1.area_name,
                    st2.user_name as register_user,
                    st1.created,
                    st3.user_name as updated_user,
                    st1.updated,
                    st1.delete_flag
                from 
                    MArea st1
                    left join MUser st2 on st1.register_user = st2.user_id
                    left join MUser st3 on st1.updated_user = st3.user_id';

        if(isset($_POST['serch'])){
            $data = array($serchWord);
            $sql .= ' where st1.area_name like ?';
        }
        $stmt = $dbs->prepare($sql);
        $stmt->execute($data);

        foreach ($stmt as $value){
            $records .= '<tr><td>'. $value['area_name'] . '</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td>'.$value['delete_flag'].'</td><td><form action="master_edit.php" method="post"><button type="submit" name="edit">編集</button><button type="submit" name="delete" onclick="return popup();">削除</button><input type="hidden" name="row-x" value="'. $value['area_id'].'"></form></td></tr>';
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
    <h1>地域マスタ</h1>

    <div class="error-message">
      <ul>
        <li>エラーメッセージ表示枠テスト1</li>
        <li>エラーメッセージ表示枠テスト2</li>
      </ul>
    </div>

    <div id="search">
        <form action="" method="post">
            <label for="price_name">地域名</label>
            <input type="text" name="serch_word" placeholder="地域名">
            <input type="submit" name="serch" value="検索">
        </form>
    </div>

    <div id="contents">
      <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
      <!-- マスタ一覧表示-->
    <table>
      <tbody>
       <tr>
         <th>地域名</th>
         <th>登録者</th>
         <th>登録日時</th>
         <th>更新者</th>
         <th>更新日時</th>
         <th>削除フラグ</th>
         <th>ボタン</th>
       <tr>
        <?= $records ?>
      </tbody>
    </table>
    <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
    </div>
  </main>
<?php include('../common/_footer.php'); ?>