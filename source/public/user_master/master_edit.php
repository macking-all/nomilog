<?php
    
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    $user_id = filter_input(INPUT_POST,'user_id');
    $user_name = filter_input(INPUT_POST,'user_name');
    $email = filter_input(INPUT_POST,'email');
    $email_flag = filter_input(INPUT_POST,'email_flag');
    $admin_flag = filter_input(INPUT_POST,'admin_flag');

    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MUser where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

    } else if(isset($_POST['delete'])){
        $sql = 'update MUser set delete_flag=1 where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        header('Location: master.php');

    } else if(isset($_POST['update'])){
        if(!$user_name){
            $errs[] = 'ユーザ名を入力してください';
        }
        if(!$email){
            $errs[] = 'メールアドレスを入力してください';
        }else if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email)){
            $errs[] = 'メールアドレスの形式で入力してください';
        }
        if(!isset($errs)){
            $sql = "UPDATE MUser SET user_name=:name, email=:email, email_flag=:email_flag, admin_flag=:admin_flag WHERE user_id=:id";
            $stmt = $dbs->prepare($sql);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email,PDO::PARAM_STR);
            $stmt->bindParam(':email_flag', $email_flag,PDO::PARAM_INT);
            $stmt->bindParam(':admin_flag', $admin_flag,PDO::PARAM_INT);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            
            header('Location: master.php');
        } else {
            foreach($errs as $err){
            $err_msgs .= '<li>'.$err.'</li>';
        }
        }
        
    }
?>

<?php include('../common/_header.php'); ?>
<body>
<main>
    <h1>ユーザマスタ編集</h1>
        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
<div id="contents">
    <form action="" method="post" id="form">
        <input type="hidden" name="user_id" value="<?= $record['user_id']; ?>">
        <label for="user_name">ユーザ名：</label>
        <input type="text" name="user_name" id="user_name" value="<?= $record['user_name']; ?>"><br>
        <label for="email">メールアドレス：</label>
        <input type="text" name="email" id="email" value="<?= $record['email']; ?>"><br>
        <label for="email_flag">メール通知を受け取る：</label>
        <input type="checkbox" name="email_flag" <?= $record['email_flag'] === '1' ? 'checked="checked"' : '';?> id="email_flag" value="<?= $record['email_flag']; ?>"><br>
        <label for="icon_img">アイコン画像</label>
        <input id="icon_img" type="file" name="icon_image">
        <label for="admin_flag">管理者フラグ：</label>
        <input type="checkbox" <?= $record['admin_flag'] === '1' ? 'checked="checked"' : '';?> name="admin_flag" id="admin_flag" value="<?= $record['admin_flag']; ?>"><br>
        <input type="button" onclick="history.back();" value="戻る">
        <input type="submit" value="更新" name="update" id="btn">
    </form>
</div>
</main>
<?php include('../common/_footer.php'); ?>
