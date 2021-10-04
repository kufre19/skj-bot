<?php
session_start();
include_once 'conn.php';

$logged = $_SESSION['logged'];
if($logged != true){
    header("location:login_bot.php");
}

$code = $_GET['order'] ?? '';
$stat =$_GET['stat'] ?? '';

if(isset($_POST['update'])){
    $code = $_POST['order'] ;
    $stat = $_POST['stat'] ;

    $sql = "UPDATE orders SET status= '$stat' WHERE invoice_id = '$code' ";
    $run = mysqli_query($conn,$sql);
    header("location:views.php");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update order status</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="order"  id="" value="<?php echo $code ?>" placeholder="Enter Order ID" >
        <input type="text" name="stat" id="" value="<?php echo $stat ?>" placeholder="Enter new status"> 
        <button type="submit" name="update">Update Status</button>
    </form>
</body>
</html>