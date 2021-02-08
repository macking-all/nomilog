<?php 

    //session_start();
    require '../dbconnect.php';

    $dbs = new Datebase();
    $dbs->dbconnect();
    
    $area_id = $_POST['area_id'];
    $area_name = $_POST['area_name'];
    $delete_flag = $_POST['delete_flag'];


    $sql = "UPDATE MArea SET area_name=:name, delete_flag=:delete_flag, WHERE area_id=:id";
    $stmt = $dbs->prepare($sql);
    
    $stmt->bindParam(':name', $area_name, PDO::PARAM_STR);
    $stmt->bindParam(':delete_flag', $delete_flag,PDO::PARAM_INT);
    $stmt->bindParam(':id', $area_id, PDO::PARAM_INT);
    $stmt->execute();
    
    header('Location: master.php');

    // if($user_name === '')
    // {
    //     $errorMessage .= 'ユーザ名を入力してください' . '<br>';
    // } else {
    //     $validateName = 'success';
    // } 

    // if($email === '')
    // {
    //     $errorMessage .= 'メールアドレスを入力してください' . '<br>';
    // } else {
    //     $validateEmail = 'success';
    // }

    // if($validateName === 'success' && $validateEmail === 'success'){
    //     $dbs = new Datebase();
    //     $dbs->dbconnect();
    //     $sql = 'update MUser set user_name=:user_name email=:email email_flag=:email_flag admin_flag=:admin_flag where user_id=:id';
    //     $stmt = $dbs->prepare($sql);
    //     $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    //     $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    //     $stmt->bindParam(':email_flag', $email_flag, PDO::PARAM_STR);
    //     $stmt->bindParam(':admin_flag', $admin_flag, PDO::PARAM_STR); 
    //     $stmt->execute();
    //     header('Location: http://localhost:8080/master.php');
    // }
    
        
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