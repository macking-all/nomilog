<?php

require '../dbconnect.php';
require '../functions.php';

session_start();

$dbs = new Database();
$dbs->dbconnect();

$price_range = filter_input(INPUT_POST, 'price_range');

// エラーメッセージ
$err_msgs = '';

if(isset($_POST['register'])){

    // ユーザ名空チェック
    if(!$price_range){
        $errs[] = '価格帯を入力してください';
    } else if(!preg_match('/^\d{4,}-\d{4,}$/', $price_range)){
        $errs[] = '1000円単位で「価格-価格」の形式で入力してください';
    }
    if(!isset($errs)){
        $sql = 'insert into MPrice (price_range) values (?)';

        $stmt = $dbs->prepare($sql);
        $data[] = $price_range;
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
        <h1>価格マスタ登録</h1>

        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
        <div id="contents">
            <form action="" method="post">
                <label for="price_range">価格帯</label>
                <input id="price_range" type="text" name="price_range" placeholder="例：1000-2000" value="<?= $price_range; ?>">
                <input type="submit" value="登録" name="register">
                <input type="button" onclick="history.back()" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('../common/_footer.php'); ?>