<?php
session_start();
include_once 'conn.php';

$logged = $_SESSION['logged'];
if($logged != true){
    header("location:login_bot.php");
}

if(isset($_GET)){
    $code = $_GET['order'];
    $sql = "DELETE FROM orders WHERE invoice_id = '$code' ";
    mysqli_query($conn,$sql);
    header("location:views.php");
}