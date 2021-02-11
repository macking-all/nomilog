<?php

//管理者フラグのところは、ドロップダウンにする

    //session_start();

    require '../dbconnect.php';
    require '../functions.php';

    $dbs = new Datebase();
    $dbs->dbconnect();
    
    //検索フォーム取得
    $serchName = $_POST['serch_name'];
    $serchEmail = $_POST['serch_email'];
    $serchFlag = $_POST['serch_flag']; 
    $keywords = [$serchName, $serchEmail, $serchFlag];
    
    $sql = "select
                st1.user_id,
                st1.user_name,
                st1.email,
                case st1.email_flag
                    when 0 then 'なし'
                    when 1 then 'あり'
                end as email_flag,
                case st1.admin_flag
                    when 1 then '管理者'
                    when 0 then ''
                end as admin_flag,
                st2.user_name as register_user,
                st1.created,
                st3.user_name as updated_user,
                st1.updated,
                st1.last_login,
                st1.delete_flag
            from
                MUser st1
                left join MUser st2 on st1.register_user = st2.user_id
                left join MUser st3 on st1.updated_user = st3.user_id";

    if(isset($_POST['serch'])){
        $sql .= ' where st1.user_name like ? and st1.email like ? and st1.admin_flag like ?';
        foreach($keywords as $keyword){
            $values[] = '%' . $keyword . '%';
        }
    }
    
    $stmt = $dbs->prepare($sql);
    $stmt->execute($values);

    foreach ($stmt as $value){
        $records .= '<tr><td>'. $value['user_name'] . '</td><td>'.$value['email'].'</td><td>'.$value['email_flag'].'</td><td>'.$value['admin_flag'].'</td><td>'.$value['register_user'].'</td><td>'.$value['created'].'</td><td>'.$value['updated_user'].'</td><td>'.$value['updated'].'</td><td>' . $value['last_login'] . '</td><td><form action="master_edit.php" method="post"><button type="submit" name="edit">編集</button><button type="submit" name="delete" onclick="return popup();">削除</button><input type="hidden" name="row-x" value="'. $value['user_id'].'"></form></td></tr>';
    }
?>

<?php include('../common/_header.php'); ?>

<body>
    <script>
        function popup(){
            return confirm('アカウントを削除しもよろしいですか?');
        }
    </script>

    <main>
    <h1>ユーザマスタ</h1>

    <div class="error-message">
      <ul>
        <li>エラーメッセージ表示枠テスト1</li>
        <li>エラーメッセージ表示枠テスト2</li>
      </ul>
    </div>

    <div id="search">
        <form action="" method="post" class="user_serach_form">
            <div>
                <label for="">表示名</label>
                <input type="text" name="serch_name">
            </div>
            <div>
                <label for="">メールアドレス</label>
                <input type="text" name="serch_email">
            </div>
            
            <div>
            <label for="">管理者権限有無</label>
            <select name="serch_flag" id="">
                <option value=""></option>
                <option value="0">一般ユーザ</option>
                <option value="1">管理者</option>
            </select>
            </div>
            <div style="margin-top: 20px;">
                <input type="submit" value="検索" name="serch">
            </div>
        </form>
    </div>

     <div id="contents">
      <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
      <!-- マスタ一覧表示-->
    <table>
      <tbody>
        <tr>
            <th>表示名</th>
            <th>メールアドレス</th>
            <th>メール通知</th>
            <th>管理者フラグ</th>
            <th>登録者</th>
            <th>登録日時</th>
            <th>更新者</th>
            <th>更新日時</th>
            <th>最終ログイン日時</th>
            <th>ボタン</th>
        </tr>
            <?= $records ?>
        </tbody>
    </table>
    <button type="button" value="新規追加"><a href="new_register.php">新規登録</a></button>
    </div>
</main>
<?php include('../common/_footer.php'); ?>