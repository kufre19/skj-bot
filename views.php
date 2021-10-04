<?php
session_start();

$logged = $_SESSION['logged'];
if($logged != true){
    header("location:login_bot.php");
}
include "view-function.php";

// echo mysqli_error($conn);
// exit;


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>SkJ ORDERS</title>

    <style>
        .main-holder{
            border-color: black;
        }
    </style>
  </head>
  <body>
   
    <div class="container">
        <div class="card main-holder shadow-lg p-3 mb-5 bg-white rounded my-5">
            <div class="card-header">
               
               <div class="mx-5"><a href="update-password.php">Change Password</a></div>
            </div>


                 <div class="card-body">
                    <div class="container" id="all-this">
                        <div class="row">
                            <?php while($row = mysqli_fetch_assoc($new_orders)){ ?>
                                <div class="col-md-3">
                                    <div class="card" id="<?php echo $row['invoice_id'];  ?>">
                                        <img class="card-img-top img-profile" src="<?php echo $row['img_url'];  ?>" style="max-width:100%; height:300px;">
                                       <?php if($row['img_url_2'] != null) 
                                       {
                                           echo " <img class='card-img-top img-profile' src='". $row['img_url_2'] ."'style='max-width:100%; height:300px;' alt='Not available'>";}   ?>
                                        <div class="card-body">
                                            <div class="card-text">
                                                <h4> </h4>
                                            </div>
                                        
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><b>Order ID:</b> <span><?php echo $row['invoice_id'];  ?></span></li>
                                                <li class="list-group-item"><b>Weight:</b> <span><?php echo $row['weight'];  ?></span></li>
                                                <li class="list-group-item"><b>Size/Length:</b><span><?php echo $row['size'];  ?></span>    </li>
                                                <li class="list-group-item"><b>Due:</b><span><?php echo $row['due_date'];  ?></span>    </li>
                                                <li class="list-group-item"><b>Branch Name:</b><span><?php echo $row['branch_name'];  ?></span>    </li>
                                                <li class="list-group-item"><b>Status:</b><span><?php echo $row['status'];  ?></span>    </li>
                                                <li class="list-group-item"><b>Remark:</b><span><?php echo $row['remarks'];  ?></span>    </li>
                                                
                                                    
                                                
                                                </ul>
                                                
                                        </div>
                                       

                                        </div>
                                        <button class="btn btn-primary" id="<?php echo $row['invoice_id'];  ?>" type="button" onclick=PrintElem(this)>PRINT ORDER</button> <br>

                                        <a href="update_status.php?order=<?php echo $row['invoice_id'];  ?>&stat=<?php echo $row['status'];  ?>" class="btn btn-success" >UPDATE STATUS</a><br>
                                        <a href="delete_order.php?order=<?php echo $row['invoice_id'];  ?>" class="btn btn-danger" >DELETE ORDER</a>
                                    </div>
                                </div>

                                <?php }?> 

                                
                        </div>
                    </div>
                </div>
        </div>
    </div>

  







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function PrintElem(elem)
        {
            var mywindow = window.open('', 'SKJ ORDERS', 'height=400,width=600');
            var order = elem.parentNode.id;
            mywindow.document.write('<html><head><title>' + document.title  + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title  + '</h1>');
            mywindow.document.write(document.getElementById(order).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
          

            return true;
        }
    </script>
  </body>
</html>