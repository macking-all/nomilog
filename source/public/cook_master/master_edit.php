<?php
    
    //session_start();
    require '../dbconnect.php';

    $dbs = new Database();
    $dbs->dbconnect();

    //POSTで送信されたユーザIDを変数に格納
    $cook_id = filter_input(INPUT_POST, 'cook_id');
    $cook_name = filter_input(INPUT_POST, 'cook_name');

    if(isset($_POST['edit'])){
        //対象のユーザIDのレコードを取得
        $sql = 'select * from MCook where cook_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $cook_id;
        $stmt->execute($data);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

    } else if(isset($_POST['update'])){
        if(!$cook_name){
            $errs[] = '料理ジャンル名を入力してください';
        }
        if(!isset($errs)){
            $sql = 'update MCook set cook_name=:cook_name where cook_id=:id';
            $stmt = $dbs->prepare($sql);
            $stmt->bindParam(':cook_name', $cook_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $cook_id, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: master.php');
        } else {
            foreach($errs as $err){
                $err_msgs .= '<li>'. $err . '</li>';
            }
        }
    } else if(isset($_POST['delete'])){
        $sql = 'update MCook set delete_flag=1 where cook_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $cook_id;
        $stmt->execute($data);
        header('Location: master.php');

    } else if(isset($_POST['restore'])){
        $sql = 'update MCook set delete_flag=0 where cook_id=?';
        $stmt = $dbs->prepare($sql);
        $data[] = $cook_id;
        $stmt->execute($data);
        header('Location: master.php');
    }
?>

<?php include('../common/_header.php'); ?>
<body>

<main>
    <h1>料理ジャンルマスタ編集</h1>
        <div class="error-message">
            <ul>
                <?= $err_msgs; ?>
            </ul>
        </div>
        
    <div id="contents">
    <form action="" method="post" id="form">
        <input type="hidden" name="cook_id" value="<?= $record['cook_id']; ?>">
        <label for="cook_name">料理ジャンル名：</label>
        <input type="text" name="cook_name" id="cook_name" value="<?= $record['cook_name']; ?>"><br>
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="更新" name="update" id="btn">
    </form>
    
    </div>
<main>
<?php include('../common/_footer.php'); ?>
