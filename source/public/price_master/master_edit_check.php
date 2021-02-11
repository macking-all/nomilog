<?php 
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();
    
    $price_id = $_POST['price_id'];
    $price_range = $_POST['price_name'];
    $delete_flag = $_POST['delete_flag'];


    $sql = "UPDATE MPrice SET price_range=:name, delete_flag=:delete_flag, WHERE price_id=:id";
    $stmt = $dbs->prepare($sql);
    
    $stmt->bindParam(':name', $price_range, PDO::PARAM_STR);
    $stmt->bindParam(':delete_flag', $delete_flag,PDO::PARAM_INT);
    $stmt->bindParam(':id', $price_id, PDO::PARAM_INT);
    $stmt->execute();
    
    header('Location: master.php');    
        
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>