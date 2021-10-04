<?php
include 'conn.php';

$sql = "SELECT invoice_id,catalog_order,branch_name,weight,remarks,due_date,status,img_url FROM orders";
$run = mysqli_query($conn,$sql);

$emp = array();
while($row = mysqli_fetch_assoc($run)){
    $emp[] = $row;
}

$jsondata = json_encode($emp);

echo $jsondata;