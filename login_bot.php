<?php
session_start();
include_once 'conn.php';
$_SESSION['logged'] = false;


if(isset($_POST['login'])){
    $pass = $_POST['pass'] ;
    $uname = $_POST['uname'] ;
    $sql = "SELECT * FROM orders_login WHERE password = '$pass' AND uname='$uname' ";
    $run = mysqli_query($conn,$sql);

    $count = mysqli_num_rows($run);
    if($count > 0){
        $_SESSION['logged'] = true;
        header("location:views.php");
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKJ LOGIN</title>
</head>
<body>

    <form action="" method="post">
    <input type="text" name="uname" id="" placeholder="Username">
    <input type="password" name="pass" id="" placeholder="Password">
    <button type="submit" name="login"> LOGIN</button>
    </form>
</body>
</html>