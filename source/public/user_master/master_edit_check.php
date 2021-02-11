<?php 

    //session_start();
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();
    
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $email_flag = $_POST['email_flag'];
    $admin_flag = $_POST['admin_flag'];

    var_dump($user_id . ':' . $user_name);

    $sql = "UPDATE MUser SET user_name=:name, email=:email, email_flag=:email_flag, admin_flag=:admin_flag WHERE user_id=:id";
    $stmt = $dbs->prepare($sql);
    var_dump($email_flag);
    $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email,PDO::PARAM_STR);
    $stmt->bindParam(':email_flag', $email_flag,PDO::PARAM_INT);
    $stmt->bindParam(':admin_flag', $admin_flag,PDO::PARAM_INT);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
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