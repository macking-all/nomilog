<?php
    
    //session_start();
    require '../dbconnect.php';
    require '../functions.php';

    session_start();

    $dbs = new Database();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $price_id = filter_input(INPUT_POST,'price_id');
    $price_range = filter_input(INPUT_POST,'price_range');

    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MPrice where price_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $price_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

    } else if(isset($_POST['update'])){
        if(!$price_range){
            $errs[] = '価格帯を入力してください';
        }
        if(!isset($errs)){
            $sql = 'update MPrice set price_range=:price_range where price_id=:id';
            $stmt = $dbs->prepare($sql);
            $stmt->bindParam(':price_range', $price_range, PDO::PARAM_STR);
            $stmt->bindParam(':id', $price_id, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: master.php');
        } else {
            foreach($errs as $err){
                $err_msgs .= '<li>'. $err . '</li>';
            }
        }
    } else if(isset($_POST['delete'])){
        $sql = 'update MPrice set delete_flag=1 where price_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $price_id;
        $stmt->execute($data);
        header('Location: master.php');

    }else if(isset($_POST['restore'])){
        $sql = 'update MPrice set delete_flag=0 where price_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $price_id;
        $stmt->execute($data);
        header('Location: master.php');
    }
?>

<?php include('../common/_header.php'); ?>
<body>

<main>
    <h1>価格マスタ編集</h1>
        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
    <div id="contents">
    <form action="" method="post" id="form">
        <input type="hidden" name="price_id" value="<?= $record['price_id']; ?>">
        <label for="price_range">価格帯：</label>
        <input type="text" name="price_range" id="price_range" value="<?= $record['price_range']; ?>"><br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="更新" name="update" id="btn">
    </form>
    </div>
<main>
<?php include('../common/_footer.php'); ?>

