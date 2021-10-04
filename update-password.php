<?php
session_start();
include_once 'conn.php';

$logged = $_SESSION['logged'];
if($logged != true){
    header("location:login_bot.php");
}

if(isset($_POST['submit'])){
    $new = $_POST['new'];
    $new_username = $_POST['uname'];
   
    $sql = "UPDATE orders_login SET password = '$new',uname = '$new_username' ";
   
    $run = mysqli_query($conn,$sql);
    session_destroy();
    header("location:login_bot.php");
}

$sql = "SELECT * FROM orders_login LIMIT 1";
$run = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($run);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password and user name</title>
</head>
<body>
    <form action="" method="post">
    <input type="text" name="uname" value="<?php echo $data['uname'] ?>" id="">
        <input type="text" name="new" value="<?php echo $data['password'] ?>" id="">
        <button type="submit" name="submit">Update Login</button>
    </form>
</body>
</html>