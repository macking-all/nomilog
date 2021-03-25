<?php
    
    require '../dbconnect.php';

    session_start();

    $dbs = new Database();
    $dbs->dbconnect();

    $user_id = filter_input(INPUT_POST,'user_id');
    $user_name = filter_input(INPUT_POST,'user_name');
    $email = filter_input(INPUT_POST,'email');

    if(isset($_POST['email_flag'])){
        $email_flag = '1';
    } else {
        $email_flag = '0';
    }
    if(isset($_POST['admin_flag'])){
        $admin_flag = '1';   
    } else {
        $admin_flag = '0';
    }

    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MUser where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        //値を詰め直す
        $user_id = $record['user_id'];
        $user_name = $record['user_name'];
        $email = $record['email'];
        $email_flag = $record['email_flag'];
        $admin_flag = $record['admin_flag'];

    } else if(isset($_POST['delete'])){
        $sql = 'update MUser set delete_flag=1 where user_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $user_id;
        $stmt->execute($data);
        header('Location: master.php');

    } else if(isset($_POST['restore'])){
        $sql = 'update MUser set delete_flag=0 where user_id=?';
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
        if(!empty($_FILES['icon_image']['name'])){
            // ファイル名をユニーク化
           $image_name = uniqid(mt_rand(), true);
            // アップロードされたファイルの拡張子を取得
            $image_name .= '.' . substr(strrchr($_FILES['icon_image']['name'], '.'), 1);
           
           /*機能していないなので後でチェックする*/
        //    $file = "images/$image_name";
        //    if(exif_imagetype($file)) {
        //        $errs[] = '画像ファイルをアップロードしてください';
        //    }
        }
        
        if(!isset($errs)){
            // imagesディレクトリにファイル保存
            move_uploaded_file($_FILES['icon_image']['tmp_name'], '../images/' . $image_name);

            $sql = "UPDATE MUser SET user_name=:name, email=:email, email_flag=:email_flag, icon_image=:icon_image, admin_flag=:admin_flag, updated_user=:updated_user WHERE user_id=:id";
            $stmt = $dbs->prepare($sql);
            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':email_flag', $email_flag, PDO::PARAM_INT);
            $stmt->bindParam(':icon_image', $image_name, PDO::PARAM_STR);
            $stmt->bindParam(':admin_flag', $admin_flag, PDO::PARAM_INT);
            $stmt->bindParam(':updated_user', $_SESSION['USER_ID']);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            $_SESSION['USER_NAME'] = $user_name;
            $_SESSION['ICON_IMAGE'] = $image_name;
            
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
    <form action="" method="post" id="form" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?= $user_id; ?>">
        <label for="user_name">ユーザ名：</label>
        <input type="text" name="user_name" id="user_name" value="<?= $user_name; ?>"><br>
        <label for="email">メールアドレス：</label>
        <input type="text" name="email" id="email" value="<?= $email; ?>"><br>
        <label for="email_flag">メール通知を受け取る：</label>
        <input type="checkbox" name="email_flag" <?= $email_flag === '1' ? 'checked="checked"' : '';?> id="email_flag"><br>
        <label for="icon_img">アイコン画像</label>
        <input id="icon_img" type="file" name="icon_image">
        <label for="admin_flag">管理者フラグ：</label>
        <input type="checkbox" <?= $admin_flag === '1' ? 'checked="checked"' : '';?> name="admin_flag" id="admin_flag"><br>
        <input type="button" onclick="location.href='master.php'" value="戻る">
        <input type="submit" value="更新" name="update" id="btn">
    </form>
</div>
</main>
<?php include('../common/_footer.php'); ?>
