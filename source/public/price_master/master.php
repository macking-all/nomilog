<?php

    //session_start(); 

    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Database();
    $dbs->dbconnect();

        $serchWord = $_POST['serch_word'];
        $sql_serchWord = '%' . $serchWord . '%';
        $sql = 'select
                    st1.price_id,
                    st1.price_range,
                    st2.user_name as register_user,
                    st1.created,
                    st3.user_name as updated_user,
                    st1.updated,
                    st1.delete_flag
                from 
                    MPrice st1
                    left join MUser st2 on st1.register_user = st2.user_id
                    left join MUser st3 on st1.updated_user = st3.user_id';

        if(isset($_POST['serch'])){
            $data = array($sql_serchWord);
            $sql .= ' where st1.price_range like ?';
        }
        $stmt = $dbs->prepare($sql);
        $stmt->execute($data);
        
        foreach ($stmt as $value){
          $setBackgroundColor = $value['delete_flag'] === '1' ? ' class="table-restoration-color"' : '';
          $setButton = $value['delete_flag'] === '1' ? '<button type="submit" name="restore" onclick="return popup2()";>復元</button>' : '<button type="submit" name="edit">編集</button><button type="submit" name="delete" onclick="return popup();">削除</button>';
          $records .= '<tr' . $setBackgroundColor . '><td>'. $value['price_range'] . '</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td><form action="master_edit.php" method="post">' . $setButton .'<input type="hidden" name="price_id" value="'. $value['price_id'].'"></form></td></tr>';
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

    <!-- マスタの中身を表示させる -->
    <main>
    <h1>価格マスタ管理画面</h1>
    
    <div id="search">
        <form action="" method="post">
            <label for="price_name">価格帯</label>
            <input id="price_name" type="text" name="serch_word" value="<?= $serchWord; ?>" placeholder="価格帯">
            <input type="submit" name="serch" value="検索">
        </form>
    </div>

    <div id="contents">
      <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
      <!-- マスタ一覧表示-->
      <table>
        <tbody>
         <tr>
          <th>価格帯</th>
          <th>登録者</th>
          <th>登録日時</th>
          <th>更新者</th>
          <th>更新日時</th>
          <th>ボタン</th>
         </tr>
          <?= $records ?>   
        </tbody>
      </table>

      <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
    </div>
  </main>



<?php include('../common/_footer.php'); ?>