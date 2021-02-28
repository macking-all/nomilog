<?php

require '../dbconnect.php';
require '../functions.php';

$dbs = new Datebase();
$dbs->dbconnect();

$cook_name = filter_input(INPUT_POST, 'cook_name');

// エラーメッセージ
$err_msgs = '';

if(isset($_POST['register'])){

    // ユーザ名空チェック
    if(!$cook_name){
        $errs[] = '料理ジャンル名を入力してください';
    }
    
    if(!isset($errs)){
        $sql = 'insert into MCook (cook_name) values (?)';

        $stmt = $dbs->prepare($sql);
        $data[] = $cook_name;
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
        <h1>料理ジャンル登録</h1>

        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
        <div id="contents">
            <form action="" method="post">
                <label for="cook_name">料理ジャンル名</label>
                <input id="cook_name" type="text" name="cook_name" value="<?= $cook_name; ?>">
                <input type="submit" value="登録" name="register">
                <input type="button" onclick="history.back()" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('../common/_footer.php'); ?>