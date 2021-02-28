<?php
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $area_id = filter_input(INPUT_POST, 'area_id');
    $area_name = filter_input(INPUT_POST, 'area_name');

    
    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MArea where area_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $area_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

    } else if(isset($_POST['update'])){
        if(!$area_name){
            $errs[] = '地域名を入力してください';
        }
        if(!isset($errs)){
            $sql = 'update MArea set area_name=:area_name where area_id=:id';
            $stmt = $dbs->prepare($sql);
            $stmt->bindParam(':area_name', $area_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $area_id, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: master.php');
        } else {
            foreach($errs as $err){
                $err_msgs .= '<li>'. $err . '</li>';
            }
        }
    } else if(isset($_POST['delete'])){
        $sql = 'update MArea set delete_flag=1 where area_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $area_id;
        $stmt->execute($data);
        header('Location: master.php');

    } else if(isset($_POST['restore'])){
        $sql = 'update MArea set delete_flag=0 where area_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $area_id;
        $stmt->execute($data);
        header('Location: master.php');
    }

?>

<?php include('../common/_header.php'); ?>
<body>

<main>
    <h1>地域マスタ編集</h1>
        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
    <div id="contents">
        <form action="" method="post" id="form">
            <input type="hidden" name="area_id" value="<?= $record['area_id']; ?>">
            <label for="area_name">地域名：</label>
            <input type="text" name="area_name" id="area_name" value="<?= $record['area_name']; ?>"><br>
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" value="更新" name="update" id="btn">
        </form>
    </div>
<main>
<?php include('../common/_footer.php'); ?>
