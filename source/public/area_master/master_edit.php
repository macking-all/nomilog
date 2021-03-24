<?php
    require '../dbconnect.php';
    require '../functions.php';
    session_start();

    $dbs = new Database();
    $dbs->dbconnect();

    $area_id = filter_input(INPUT_POST, 'area_id');
    $area_name = filter_input(INPUT_POST, 'area_name');
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = filter_input(INPUT_GET, 'action');

    switch ($action) {
        case 'edit':
            $sql = 'select * from MArea where area_id=?';
            $stmt = $dbs->prepare($sql);
            $data[] = $area_id;
            $stmt->execute($data);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            $area_name = $record['area_name'];
            break;
        case 'update':
            if($area_name){
            $sql = 'update MArea set area_name=:area_name where area_id=:id';
            $stmt = $dbs->prepare($sql);
            $stmt->bindValue(':area_name', $area_name, PDO::PARAM_STR);
            $stmt->bindValue(':id', $area_id, PDO::PARAM_INT);
            $stmt->execute();
            header('Location: master.php');
            } else {
                $errs[] = '地域名を入力してください';
            }
            break;
        case 'delete':
            $sql = 'update MArea set delete_flag=1 where area_id=?';
            $stmt = $dbs->prepare($sql);
            $data[] = $area_id;
            $stmt->execute($data);
            header('Location: master.php');
            break;
        case 'restore':
            $sql = 'update MArea set delete_flag=0 where area_id=?';
            $stmt = $dbs->prepare($sql);
            $data[] = $area_id;
            $stmt->execute($data);
            header('Location: master.php');
            break;
        default:
            exit;
    }
}

    if(isset($errs)){
        foreach($errs as $err){
            $err_msgs .= '<li>'. $err . '</li>';
        }
    }
    
    // if(isset($_POST['edit'])){
        
    //     // select文は不要：nameなどはpostされているので、
        
    //     // update,delete,restoreの処理をまとめる
    // } else if(isset($_POST['update'])){
    //     if(!$area_name){
    //         $errs[] = '地域名を入力してください';
    //     }
    //     if(!isset($errs)){
            
    //     } else {
    //         foreach($errs as $err){
    //             $err_msgs .= '<li>'. $err . '</li>';
    //         }
    //     }
    // } else if(isset($_POST['delete'])){
        

    // } else if(isset($_POST['restore'])){
        
    // }

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
        <form action="?action=update" method="post" id="form">
            <input type="hidden" name="area_id" value="<?= $record['area_id']; ?>">
            <label for="area_name">地域名：</label>
            <input type="text" name="area_name" id="area_name" value="<?= $area_name; ?>"><br>
            <input type="button" onclick="location.href='master.php'" value="戻る">
            <input type="submit" value="更新" name="update" id="btn">
        </form>
    </div>
<main>
<?php include('../common/_footer.php'); ?>