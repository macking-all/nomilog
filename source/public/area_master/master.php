<?php
    require '../dbconnect.php';
    require '../functions.php';

    session_start();

    $dbs = new Database();
    $dbs->dbconnect();

        $serchWord = $_POST['serch_word'];
        $sql_serchWord =  '%' . $serchWord . '%';

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
            $data = array($sql_serchWord);
            $sql .= ' where st1.area_name like ?';
        }
        $stmt = $dbs->prepare($sql);
        $stmt->execute($data);

        foreach ($stmt as $value){
            $setBackgroundColor = $value['delete_flag'] === '1' ? ' class="table-restoration-color"' : '';
            $setButton = $value['delete_flag'] === '1' ? '<form action="master_edit.php?action=restore" method="post"><button type="submit" name="restore" onclick="return popup2()";>復元</button>' : '<form action="master_edit.php?action=edit" method="post"><input type="hidden" name="area_id" value="'. $value['area_id'].'"><button type="submit" name="edit">編集</button></form><form action="master_edit.php?action=delete" method="post"><button type="submit" name="delete" onclick="return popup();">削除</button>';
            $records .= '<tr'. $setBackgroundColor . '><td>'. $value['area_name'] . '</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td>' . $setButton . '<input type="hidden" name="area_id" value="'. $value['area_id'].'"></form></td></tr>';
        }
?>

<?php include('../common/_header.php'); ?>
<body>
    <script>
        //レコード削除の確認
        function popup(){
            return confirm('このマスタを削除してもよろしいですか?');
        }
        function popup2(){
            return confirm('このマスタを復元してもよろしいですか?');
        }
    </script>

    <mian>
    <h1>地域マスタ</h1>

    <div id="search">
        <form action="" method="post">
            <label for="price_name">地域名</label>
            <input type="text" name="serch_word" placeholder="地域名" value="<?= $serchWord ?>">
            <input type="submit" name="serch" value="検索">
        </form>
    </div>

    <div id="contents">
      <button type="button" value=""><a href="new_register.php">新規登録</a></button>
      <!-- マスタ一覧表示-->
    <table>
      <tbody>
       <tr>
         <th>地域名</th>
         <th>登録者</th>
         <th>登録日時</th>
         <th>更新者</th>
         <th>更新日時</th>
         <th>ボタン</th>
       <tr>
        <?= $records ?>
      </tbody>
    </table>
    <button type="button" value=""><a href="new_register.php">新規登録</a></button>
    </div>
  </main>
<?php include('../common/_footer.php'); ?>