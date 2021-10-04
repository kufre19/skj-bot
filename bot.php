
<?php
include_once 'conn.php';
include_once 'message.php';
include_once 'commands.php';
include 'vendor/autoload.php';
$new_content =  file_get_contents("php://input");


function log_all_error($conn,$result){
    $data = $result;
    $code = $data['error_code'];
    $error = $data['description'];
    $sql = "INSERT INTO bot_logs (error_code,error) VALUES ('$code','$error')";
    $run = mysqli_query($conn,$sql);
}

function update_order_stat($conn,$orderid,$update){
    $sql = "UPDATE orders SET status='$update' WHERE invoice_id = '$orderid' ";
    $run = mysqli_query($conn,$sql);

    if(!$run ){
        return 0;
    }else{
       return 1;

    }

}

function fetch_order_stats($conn,$invoice_id){
    $sql = "SELECT * FROM orders WHERE invoice_id = '$invoice_id'";
    $run = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);

    if(!$run ){
        return 0;
    }else{
        $data = mysqli_fetch_assoc($run);
        return $data;

    }
}


function save_catalog_order($conn,$invoice_id,$chatId,$size,$order,$img){
    $sql = "INSERT INTO  orders (chat_id,invoice_id,branch_name,size,remarks,due_date,catalog_order,status,photo_id) 
    VALUES('$chatId','$invoice_id','$branch_name','$size','$remarks','$due_date','$order','pending','$img')";
    $run = mysqli_query($conn,$sql);

    if(!$run){
        return 0;
    }else{
        return 1;

    }
}

function check_if_product_code_exist($conn,$order){
   
    $str =  $order;
    $n1 = explode('ORDER-',$str);
    $n1 = $n1[1];
    $n2 = preg_split('/,/',$n1);
    $pro_code = $n2[0];
    $sql = "SELECT * FROM catalogs WHERE product_code = '$pro_code' LIMIT 1 ";
    $run = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);
    $data = mysqli_fetch_assoc($run);
    $img = $data['photo_id'] ??  ' ';
    $send = array($count,$img);

    return $send;


}



function upload_to_catalog($conn,$photo,$caption,$product_code,$category){
 
    $sql = "INSERT INTO catalogs (photo_id,caption,product_code,category) VALUES('$photo','$caption','$product_code','$category')";
    $run = mysqli_query($conn,$sql);
    if($run){
        return 1;
    }

    return 0;
}



function make_id(){
    $first = rand(10,100);
    $last = rand(100,10000);
    $id = str_pad($first + $last,6,"S0",STR_PAD_LEFT);
    return $id;
}



function create_invoice_id($conn){
    

    do {
        $id = make_id();
        $sql = "SELECT * FROM orders WHERE invoice_id = '$id'";
        $run = mysqli_query($conn,$sql);
        $result = mysqli_num_rows($run);
    } while ($result > 0);

    return $id;
}



function create_invoice($conn,$chatId,$invoice_id,$photo_id,$weigth,$branch_name,$length,$remarks,$due_date,$img_download){
    $sql = "INSERT INTO  orders (chat_id,invoice_id,photo_id,weight,branch_name,size,remarks,due_date,status,img_url) 
    VALUES('$chatId','$invoice_id','$photo_id','$weigth','$branch_name','$length','$remarks','$due_date','pending','$img_download')";
    $run = mysqli_query($conn,$sql);

    if(!$run){
        return 0;
    }else{
        return 1;

    }
    
}

function send_catalog($conn,$want){
    $sql =  "SELECT * FROM catalogs WHERE category = '$want' ORDER BY RAND()  ";
    $run =  mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($run);
    

    return $data;

}

function download_image($image_id){
     $img_url = "https://api.telegram.org/file/bot1843350988:AAGOpMoZ5MIrAJiYkUwTzBvvM9nr-vCT8UE/";
     $fetch_path = file_get_contents("https://api.telegram.org/bot1843350988:AAGOpMoZ5MIrAJiYkUwTzBvvM9nr-vCT8UE/getFile?file_id=".$image_id);
     $path = json_decode($fetch_path,true);
     $new = $path['result']['file_path'];
     $data = $img_url.$new;
     return $data;

     

}








$update = json_decode($new_content, true);
$token = '1843350988:AAGOpMoZ5MIrAJiYkUwTzBvvM9nr-vCT8UE';
$api = 'https://api.telegram.org/bot' . $token;

$text = $update['message']['text'];
$photo_1 =  $update['message']['photo'][3]['file_id'];
$photo_2 =  $update['message']['photo'][2]['file_id'];
$photo_3 =  $update['message']['photo'][1]['file_id'];
$photo_4 = $update['message']['photo'][0]['file_id'];
$photo = $photo_1 ?? $photo_2 ?? $photo_3 ?? $photo_4;

$caption = $update['message']['caption'];
$chatId = $update['message']['chat']['id'];
$senderId = $update['message']['from']['id'];
$senderName = $update['message']['from']['first_name'];

if(isset($update['callback_query'])){
    $callBackQueryFrom = $update['callback_query']['from']['id'];
    $callBackQueryMessageId = $update['callback_query']['message']['message_id'];
    $callBackData = $update['callback_query']['data'];
    $callbackID = $update['callback_query']['id'];
    
    //  file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom.'&text=Order received your ID is ');
    //  exit(0);
    
    // file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID.'&text= hi');
    // exit(0);
    
    
}







if($senderId == $admin_id){
   

    if($photo != null){
        if($caption != null){
            $new_cap = explode('\n',$caption);
            $product_code = $new_cap[0];
            $product_code = preg_split('/:/',$product_code);
            $category = strtolower($product_code[3]);
            $product_code = preg_split('/\s+/',$product_code[1]);
            $product_code = $product_code[0];
            $upload = upload_to_catalog($conn,$photo,$caption,$product_code,$category);
        
            if($upload >0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= upload successfull('.$product_code.')');
                exit(0);
            }else{
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= upload failed try again later');
                exit(0);
            }
        }else{
        file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please Enter a proper format to upload a product");
        exit(0);
        
        // file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$photo."&caption= hello"."&reply_markup=".$keyboard);
        // exit(0);
    }
        
        // file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= uplaod a product admin');
    }
    if($text != null ){

        if(strpos($text,"ADMIN-UPDATE-STATUS:") !== false ){
            $command = $text;
            $command = explode('ADMIN-UPDATE-STATUS:',$command);
            $command = $command[1];
            $n = preg_split('/,/',$command);
            $orderid = $n[0];
            $orderid = str_replace(' ', '', $orderid);
            $update = $n[1];
            $update_order = update_order_stat($conn,$orderid,$update);
            if($update_order == 1){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Order updated successfully ");
                exit(0);
            }else{
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Error updating pls use the right format for this command ");
                exit(0);
            }

        }else{
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= ",$admin_command_help);
            exit(0);
        }

    }
}elseif ($senderId != $admin_id ||isset($update['callback_query'])){
    if($text != null ){
        if($text == '/start'){
       
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$welcome_msg);
            exit(0);
        }
        if(in_array($text,$command)){
            if($text == '/customorder'){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$how_to_custom_order);
                file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$cusom_order_sample_id);
                exit(0);
            }

            if($text == '/stockorder'){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$how_to_catalog_order);
                sleep(1);
                file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$catalog_order_img_sample.'&caption= Please use the format in the sample screenshot');
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= ".$category_listing);
                exit(0);
                
              

            }

            

            if($text == '/orderstatus'){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= To check the status of your order send the following command. 'STATUS-order ID' i.e 'STATUS-00167' ");
                exit(0);
            }

        }

        if(strpos(strtolower($text),"status-") !== false){
            $query = strtolower($text);
            $str = explode('status-',$query);
            $invoice_id = $str[1];
            $invoice_id = strval($invoice_id);
            $invoice_id = str_replace(' ', '', $invoice_id);
            $stats = fetch_order_stats($conn,$invoice_id);

            if($stats == 0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Error getting order status '.$invoice_id. ' Please make use of a correct command format with a correct order ID i.e (STATUS- 00872)');
                exit(0);
            }else{
                $status = $stats['status'];
                $order_photo = $stats['photo_id'];
                $stat_info = urlencode("STATUS: ".$status."\n"."ORDER ID: ".$invoice_id);
                file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$order_photo."&caption= ".$stat_info);
                exit(0);
                
                // file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= ORDER ID: '.$invoice_id.' STATUS: '.$status);
                // exit(0);
            }
        }

        if(strpos(strtolower($text),"show me") !== false){
            $edit = strtolower($text);
            $edit = preg_split('/\s+/',$edit);
            $want = $edit[2];
            if(in_array($want,$list_of_categories)){
                // file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Error getting order status '.$invoice_id. ' ok');
                // exit(0);
                $catalog = send_catalog($conn,$want);
                $catalong_photo = $catalog['photo_id'];
                $catalog_cap = $catalog['caption'];
                $keyboard = keyBoard($want);
                file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$catalong_photo."&caption=".$catalog_cap."&reply_markup=".$keyboard);
                exit(0);
            }else{
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Product category doesn't exist");
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=".$category_listing);
                exit(0);
            }
           
        }

        if(strpos(strtolower($text),"order-") !== false){
            $order = strtolower($text);
            $check_product_code = check_if_product_code_exist($conn,$order);
            $code_count = $check_product_code[0] ?? ' ';
            $pro_img = $check_product_code[1] ?? ' ';
            
            if($code_count < 1){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Invalid product ID or command Format. Please use the right command format to order or a correct product code ");
                exit(0);
            }
            
            $invoice_id = create_invoice_id($conn);
            $save_order = save_catalog_order($conn,$invoice_id,$chatId,$size,$order,$pro_img);
            if($save_order > 0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= You've made an order. Your order ID is ".$invoice_id);
                exit(0);
            }

            // file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= You made an order ');
            // exit(0);
        }else{
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Unknown command. Please select a command from the menu to get information on how to use this bot ");
            exit(0);
        }


    }

    if($photo != null){
        if($caption != null){
            $new_cap = explode('\n',$caption);
            $order = $new_cap[0];
            $order = preg_split('/\s+/',$order);
            if(sizeof($order) != 5){
                file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$cusom_order_sample_id. "&caption= Please resend your order with all necessary details");
                exit(0);
            }
            $branch_name = $order[0];
            $weigth = $order[1];
            $length = $order[2];
            $remarks = $order[3];
            $due_date = $order[4];
            $photo_id = $photo;
            $img_download = download_image($photo_id);
            $invoice_id = create_invoice_id($conn);
            $invoice  = create_invoice($conn,$chatId,$invoice_id,$photo_id,$weigth,$branch_name,$length,$remarks,$due_date,$img_download);
            if($invoice == 1){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text=Order received your ID is '.$invoice_id);
                exit(0);
            }else{
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Db error ');
                exit(0);
            }
            // file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= other info '.$invoice_id );
            // exit(0);

            
        }
        else{
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Unknown command '.$welcome_msg);
            exit(0);
        }
    }

    if($callBackQueryFrom != null && $callBackQueryFrom != $admin_id  ){

        $start = $callBackData;
        $keyboard = keyBoard($start);
        $catalog = send_catalog($conn,$start);
        $weight = $catalog['weight'];
        $catalog_code = $catalog['product_code'];
        $catalong_photo = $catalog['photo_id'];
        $catalog_cap = $catalog['caption'];
       

            // file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom.'&text=Order received your ID is ');
            // exit(0);
        $post = [
            
        
                        'type'=>'photo' ,
                        'media' => $catalong_photo,
                        'caption'=> $catalog_cap
            
        ];
        $post = json_encode($post);
        file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
        $test = json_decode( file_get_contents($api.'/editMessageMedia?chat_id='.$callBackQueryFrom.'&message_id='.$callBackQueryMessageId.'&media='.$post.'&reply_markup='.$keyboard));
        exit(0);
        
        // if(isset($test['ok'])){
        //     file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom.'&text=Order received your ID is ');
           
        //     log_all_error($conn,$test);
        //      exit(0);
            
        // }
       
    }
    
   
    
}








// $chatId = $update["message"]["chat"]["id"];
// $photo_id = $update['message']['photo'][0]['file_id'];
// $response = json_decode(file_get_contents($bot_path."/getFile?file_id=".$photo_id));

// file_get_contents($bot_path."/sendPhoto?chat_id=".$chatId."&photo=".$photo_id);

// function set_admin($admin_id){

// }

