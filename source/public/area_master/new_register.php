<?php

require '../dbconnect.php';
require '../functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

$area_name = filter_input(INPUT_POST, 'area_name');

// エラーメッセージ
$err_msgs = '';

if(isset($_POST['register'])){

    // 空チェック
    if(!$area_name){
        $errs[] = '地域名を入力してください';
    }
    
    if(!isset($errs)){
        $sql = 'insert into MArea (area_name) values (?)';

        $stmt = $dbs->prepare($sql);
        $data[] = $area_name;
        $stmt->execute($data);
        $dbs = null;

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
        <h1>新規地域登録</h1>

        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
        <div id="contents">
            <form action="" method="post">
                <label for="area_name">地域名</label>
                <input id="area_name" type="text" name="area_name" value="<?= $area_name; ?>">
                <input type="submit" value="登録" name="register">
                <input type="button" onclick="history.back()" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('../common/_footer.php'); ?>