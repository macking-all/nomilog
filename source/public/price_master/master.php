<?php

    //session_start(); 

    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

        $serchWord = $_POST['serch_word'];
        $serchWord = '%' . $serchWord . '%';
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
            $data = array($serchWord);
            $sql .= ' where st1.price_range like ?';
        }
        $stmt = $dbs->prepare($sql);
        $stmt->execute($data);

        $tableHeaderHtml = '<tr class="table-header-color"><th>価格帯</th><th>登録者</th><th>登録日時</th><th>更新者</th><th>更新日時</th><th>削除フラグ</th><th>ボタン</th>';
        foreach ($stmt as $value){
            $records .= '<tr><td>'. $value['price_range'] . '</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td>'.$value['delete_flag'].'</td><td><form action="master_edit.php" method="post"><button class="main-button btn--gray btn--shadow btn--small editing--btn--gray" type="submit" name="edit">編集</button><button class="main-button btn--gray btn--shadow btn--small delete--btn--gray" type="submit" name="delete" onclick="return popup();">削除</button><input type="hidden" name="row-x" value="'. $value['price_id'].'"></form></td></tr>';
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

    <form action="" method="post" id="serch">
        
    </form>

    <!-- マスタの中身を表示させる -->
    <main>
    <div class="main-font">
      <h1><span>価格マスタ管理画面</span></h1>
    </div>

    <div class="error-message">
      <ul>
        <li>エラーメッセージ表示枠テスト1</li>
        <li>エラーメッセージ表示枠テスト2</li>
      </ul>
    </div>
    
    <div class="search each-master-search">
        <form action="" method="post">
            <label for="price_name">価格帯</label>
            <input id="price_name" type="text" name="serch_word" placeholder="価格帯">
            <input class="btn--blue btn--shadow btn--middle" type="submit" name="serch" value="検索">
        </form>
      </div>
      <!-- <div class="main-button each-master-search-button-layout">
        <div class="btn--blue btn--shadow btn--middle search-layout">検索</div>
      </div> -->
    </div>

    <div class="usermaster-table">
      <div class="main-button master-new-button">
        <a href="./addprice.html" class=" btn--blue btn--shadow btn--middle">新規追加</a>
      </div>
      <table>
        <tbody>
            <?= $tableHeaderHtml ?>
            <?= $records ?>   
        </tbody>
      </table>
      <div class="main-button master-new-button">
        <a href="./addprice.html" class=" btn--blue btn--shadow btn--middle">新規追加</a>
      </div>
    </div>
  </main>



<?php include('../common/_footer.php'); ?>