<?php
include "conn.php";





function get_new_orders($conn){
    $sql = "SELECT * FROM orders   ";
    $run = mysqli_query($conn,$sql);
    return $run;
}



$new_orders = get_new_orders($conn);