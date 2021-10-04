<?php

include_once 'conn.php';
include_once 'message.php';
include_once 'commands.php';
include 'vendor/autoload.php';
$new_content =  file_get_contents("php://input");



########## DEFINED ADMIN FUNCIONS LIVE HERE HERE ###########################################################################
function make_admin_account($conn,$senderId){
    $sql = "UPDATE admin_account SET admin_id='$senderId' WHERE id = '1' ";
    $run = mysqli_query($conn,$sql);
   
}

function check_admin_account($conn,$senderId){
    $sql = "SELECT * FROM admin_account WHERE admin_id = '$senderId' ";
    $run = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);
    $data = mysqli_fetch_assoc($run);
    if($count > 0){
        return 1;
    }else{
        return 0;
    }
}
function check_admin_upload_chat_id($conn,$senderId){
    $sql = "SELECT *  FROM admin_upload_sessions WHERE admin_id = '$senderId' LIMIT 1";
    $run =  mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);
    if($count > 0){
        return 1;
    }else{

        return 0;
    }
    
}


function add_admin_upload_session($conn,$senderId){
    $sql = "INSERT INTO admin_upload_sessions (admin_id) VALUES ('$senderId')";
    $run =  mysqli_query($conn,$sql);
}

function delete_admin_upload_session($conn,$senderId){
    $sql = "DELETE FROM admin_upload_sessions WHERE admin_id = '$senderId' ";
    $run =  mysqli_query($conn,$sql);
}

function create_admin_upload_session($conn,$senderId){
    $check_id = check_admin_upload_chat_id($conn,$senderId);
    return $check_id;
}

function save_upload_image($conn,$senderId,$photo){
    $sql = "UPDATE admin_upload_sessions SET photo = '$photo' WHERE admin_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);

}

function save_product_code($conn,$senderId,$code){
    $sql = "UPDATE admin_upload_sessions SET product_code = '$code' WHERE admin_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_product_weight($conn,$senderId,$weight){
    $sql = "UPDATE admin_upload_sessions SET weight = '$weight' WHERE admin_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_product_category($conn,$senderId,$category){
    $sql = "UPDATE admin_upload_sessions SET category = '$category' WHERE admin_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}


function upload_to_catalog($conn,$photo,$weight,$product_code,$category){
 
    $sql = "INSERT INTO catalogs (photo_id,weight,product_code,category) VALUES('$photo','$weight','$product_code','$category')";
    $run = mysqli_query($conn,$sql);
    if($run){
        return 1;
    }

    return 0;
}


function fetch_upload_to_save($conn,$senderId){
    $sql = "SELECT *  FROM admin_upload_sessions WHERE admin_id = '$senderId' LIMIT 1";
    $run =  mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($run);
    $count = mysqli_num_rows($run);

    if($count > 0){
        return $data;
    }else{
        return 0;
    }

}

function delete_upload_session($conn,$senderId){
    $sql = "DELETE FROM admin_upload_sessions WHERE admin_id = '$senderId' ";
    $run =  mysqli_query($conn,$sql);
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


########## DEFINED ADMIN FUNCTIONS ENDS HERE ##############################################################################



########## DEFINED USER FUNCIONS LIVE HERE HERE ###########################################################################
function send_catalog($conn,$want,$offset){
    $sql =  "SELECT * FROM catalogs WHERE category = '$want' LIMIT $offset, 1  ";
    $run =  mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($run);
    

    return $data;

}
function check_order_chat_id($conn,$senderId){
    $sql = "SELECT *  FROM order_sessions WHERE chat_id = '$senderId' LIMIT 1";
    $run =  mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);
    if($count > 0){
        return 1;
    }else{

        return 0;
    }
    
}

function count_steps($conn,$senderId){
    $sql = "SELECT step  FROM order_sessions WHERE chat_id = '$senderId' LIMIT 1";
    $run =  mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($run);
    $data = $data['step'];

    return $data;
    
}



function add_new_order_session($conn,$senderId){
    $sql = "INSERT INTO order_sessions (chat_id) VALUES ('$senderId')";
    $run =  mysqli_query($conn,$sql);
}

function delete_order_session($conn,$senderId){
    $sql = "DELETE FROM order_sessions WHERE chat_id = '$senderId' ";
    mysqli_query($conn,$sql);
}

function create_order_session($conn,$senderId){
    $check_id = check_order_chat_id($conn,$senderId);
    return $check_id;
}

function save_order_image($conn,$senderId,$photo,$step){
    $sql = "UPDATE order_sessions SET order_photo = '$photo', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);

}

function  save_order_image2($conn,$senderId,$photo,$step){
    $sql = "UPDATE order_sessions SET photo_id_2 = '$photo', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_order_branchname($conn,$senderId,$branch_name,$step){
    $sql = "UPDATE order_sessions SET branch_name = '$branch_name', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_order_weight($conn,$senderId,$weight,$step){
    $sql = "UPDATE order_sessions SET weight = '$weight', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}


function save_order_size($conn,$senderId,$size,$step){
    $sql = "UPDATE order_sessions SET length = '$size', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_order_remark($conn,$senderId,$remark,$step){
    $sql = "UPDATE order_sessions SET remark = '$remark', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_order_due($conn,$senderId,$due,$step){
    $sql = "UPDATE order_sessions SET due_date = '$due', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}
function update_steps($conn,$senderId,$step){
    $sql = "UPDATE order_sessions SET  step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function save_order_product_code($conn,$senderId,$product_code,$step){
    $sql = "UPDATE order_sessions SET product_code = '$product_code', step='$step' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function get_product_code($conn,$code){
    $sql = "select * from catalogs where product_code = '$code'";
    $run = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);
    $data = mysqli_fetch_assoc($run);
    if($count > 0){
        return $data;
    }else{
        return 0;
    }

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



function save_order_invoice_id($conn,$senderId,$invoice_id){
    $sql = "UPDATE order_sessions SET invoice_id = '$invoice_id' WHERE chat_id = '$senderId'";
    $run =  mysqli_query($conn,$sql);
}

function  fetch_order_details($conn,$senderId,$orderId){
    $sql = "SELECT *  FROM order_sessions WHERE chat_id = '$senderId' AND invoice_id = '$orderId' LIMIT 1";
    $run =  mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($run);
    $count = mysqli_num_rows($run);

    if($count > 0){
        return $data;
    }else{
        return 0;
    }
    
}

function create_invoice($conn,$chatId,$invoice_id,$photo_id,$weigth,$branch_name,$length,$remarks,$due_date,$product_code,$img_location,$img_location2){
    $sql = "INSERT INTO  orders (chat_id,invoice_id,photo_id,weight,branch_name,size,remarks,due_date,status,product_code,img_url,img_url_2) 
    VALUES('$chatId','$invoice_id','$photo_id','$weigth','$branch_name','$length','$remarks','$due_date','pending','$product_code','$img_location','$img_location2')";
    $run = mysqli_query($conn,$sql);

    if(!$run){
        return 0;
    }else{
        return 1;

    }
    
}

function check_if_product_code_exist($conn,$code){
   
    // $str =  $order;
    // $n1 = explode('ORDER-',$str);
    // $n1 = $n1[1];
    // $n2 = preg_split('/,/',$n1);
    // $pro_code = $n2[0];
    $sql = "SELECT * FROM catalogs WHERE product_code = '$code' LIMIT 1 ";
    $run = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($run);
    $data = mysqli_fetch_assoc($run);
    $img = $data['photo_id'] ??  ' ';
    $weight = $data['weight'];
    $send = array($count,$img,$weight);

    return $send;


}

function download_image_link($image_id){
    $img_url = "https://api.telegram.org/file/bot1843350988:AAGOpMoZ5MIrAJiYkUwTzBvvM9nr-vCT8UE/";
    $fetch_path = file_get_contents("https://api.telegram.org/bot1843350988:AAGOpMoZ5MIrAJiYkUwTzBvvM9nr-vCT8UE/getFile?file_id=".$image_id);
    $path = json_decode($fetch_path,true);
    $new = $path['result']['file_path'];
    $data = $img_url.$new;
    $m = "not available";

    if($new == null){
        return $m;
    }
    return $data;

    

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





########## DEFINED USER FUNCTIONS ENDS HERE ##############################################################################




//collecting data from telegram payload
$update = json_decode($new_content, true);
$token = '1843350988:AAGOpMoZ5MIrAJiYkUwTzBvvM9nr-vCT8UE';
$api = 'https://api.telegram.org/bot' . $token;

$text = $update['message']['text'];
$caption = $update['message']['caption'];
$chatId = $update['message']['chat']['id'];
$senderId = $update['message']['from']['id'];
$senderName = $update['message']['from']['first_name'];
$message = strtolower($text);
$photo_1 =  $update['message']['photo'][3]['file_id'];
$photo_2 =  $update['message']['photo'][2]['file_id'];
$photo_3 =  $update['message']['photo'][1]['file_id'];
$photo_4 = $update['message']['photo'][0]['file_id'];
$photo = $photo_1 ?? $photo_2 ?? $photo_3 ?? $photo_4;




if(isset($update['callback_query'])){
    $callBackQueryFrom = $update['callback_query']['from']['id'];
    $callBackQueryMessageId = $update['callback_query']['message']['message_id'];
    $callBackData = $update['callback_query']['data'];
    $callbackID = $update['callback_query']['id'];


    if(strpos($callBackData,'Cancel order') !== false){
        $check_order_session =  check_order_chat_id($conn,$callBackQueryFrom);
        
        if($check_order_session == 0){
            file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
            file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom."&text= No session found start a new order session   ");
            exit(0);
        }
        delete_order_session($conn,$callBackQueryFrom);
        file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
        file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom."&text= Order session has been cleared you can ");
        exit(0);
    }

    if(strpos($callBackData,'order now:') !== false){
        $check_order_session =  check_order_chat_id($conn,$callBackQueryFrom);
        
        if($check_order_session == 0){
            file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
            file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom."&text= No session found start a new order session ");
            exit(0);
        }
        $split_text = preg_split('/:/',$callBackData);
        $orderId = $split_text[1];
        $orderId = str_replace(' ', '', $orderId);
        $fetched_details = fetch_order_details($conn,$callBackQueryFrom,$orderId);
        if($fetched_details == 0){
            file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
            file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom."&text= Please check that you've entered the correct ID and also in the right format");
            exit(0);
        }
        $invoice_id = $fetched_details['invoice_id'];
        $photo_id = $fetched_details['order_photo'];
        $photo_id2 = $fetched_details['photo_id_2'];
        $branch_name = $fetched_details['branch_name'];
        $length = $fetched_details['length'];
        $remarks = $fetched_details['remark'];
        $weight = $fetched_details['weight'];
        $due_date = $fetched_details['due_date'];
        $product_code = $fetched_details['product_code']??'nulled';
        $img_link = download_image_link($photo_id);
        $img_link2 = download_image_link($photo_id2);
        $img_location = download_image_to_server($img_link,$invoice_id);
        if($img_link2 != 'not available'){
            $u = $invoice_id.'-2';
            $img_location2 = download_image_to_server($img_link2,$u);
        }
        
        create_invoice($conn,$callBackQueryFrom,$invoice_id,$photo_id,$weight,$branch_name,$length,$remarks,$due_date,$product_code,$img_location,$img_location2);
        delete_order_session($conn,$callBackQueryFrom);
        file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
        file_get_contents($api.'/sendMessage?chat_id='.$callBackQueryFrom.'&text=Order received your ID is '.$invoice_id.' you can use this to track your order. Select /orderstatus to know how');
        exit(0);
    }
    
  
    
    $strip_data = preg_split('/\s+/',$callBackData);
    $want = str_replace(' ','', $strip_data[0]);
  

    // }


    if(strpos($callBackData,"next") !== false){
        $offset =  $strip_data[2] + 1;
        $go_back = $offset ;
        $go_forward = $offset;
        
        
    }
    if(strpos($callBackData,"back") !== false){
        $offset =  $strip_data[2] - 1;
        $go_back = $offset ;
        $go_forward = $offset;
        if($strip_data[2] == 0 || $offset == 0){
            $offset = 0;
            $go_back = 0;
            $go_forward = $offset ;
        }
        
    }

    $keyboard = keyBoard($want,$go_forward,$go_back);
    $catalog = send_catalog($conn,$want,$offset);
    $weight = $catalog['weight'];
    $pro_code = $catalog['product_code'];
    $catalog_code = $catalog['product_code'];
    $cap = urlencode("Product code:$pro_code\nProduct weight:$weight");
    $catalong_photo = $catalog['photo_id'];
    // $catalog_cap = $catalog['caption'];
    $post = [
        
    
    'type'=>'photo' ,
    'media' => $catalong_photo,
    'caption'=>$cap
    
    ];
    $post = json_encode($post);
    file_get_contents($api.'/answerCallBackQuery?callback_query_id='.$callbackID);
    $test = json_decode( file_get_contents($api.'/editMessageMedia?chat_id='.$callBackQueryFrom.'&message_id='.$callBackQueryMessageId.'&media='.$post.'&reply_markup='.$keyboard));
    exit(0);

 
    
}



//bot logic starts here

##################################  ADMIN STARTS  #####################################################################

if($photo != null){
    $get_admin_id = check_admin_account($conn,$senderId);
    if($get_admin_id == 1){
        $check_session = check_admin_upload_chat_id($conn,$senderId);
        if($check_session == 0){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please start a upload session first with this command 'admin upload product'");
            exit(0);
        }
        save_upload_image($conn,$senderId,$photo);
        file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send product code in this format 'admin code:B02E3'");
        exit(0);

    }
}

if(strpos($message,"admin")  !== false ){
    $get_admin_id = check_admin_account($conn,$senderId);
    //ADMIN LOGIC BELONGS HERE
    if(strpos($message,strtolower("make admin AHSJSKoindhbd76979ajmjnklsjd/../.dddww32"))){
        make_admin_account($conn,$senderId);
        if($get_admin_id == 1){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= This account has already been made the admin account to SKJ ORDER BOT');
            exit(0);
        }else{
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= This account has been made the admin account to SKJ ORDER BOT');
            exit(0);
        }
        
    }
    //check if account is admin
   
    if($get_admin_id == 1){
       //if verified then any admin command runs 
       if(strpos($message,strtolower("make admin AHSJSKoindhbd76979ajmjnklsjd/../.dddww32"))){
           make_admin_account($conn,$senderId);
           file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= This account has already been made the admin account to SKJ ORDER BOT');
           exit(0);
       }
       //
       if(strpos($message,'admin upload product') !== false){
            $check_id =  check_admin_upload_chat_id($conn,$senderId);
            if($check_id == 1){
                delete_admin_upload_session($conn,$senderId);
                add_admin_upload_session($conn,$senderId);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Send a photo of the product');
                exit(0);
            }else{
                add_admin_upload_session($conn,$senderId);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Send a photo of the product');
                exit(0);
                
            }

        }
        //
        if(strpos($message,'admin code:') !== false){
            $check_session = check_admin_upload_chat_id($conn,$senderId);
            if($check_session == 0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please start a upload session first with this command 'admin upload product'");
                exit(0);
            }else{

                 $split_text = preg_split('/:/',$text);
                 if($split_text[0] == "admin code"){
                    $code =str_replace(' ','', $split_text[1]);
                    save_product_code($conn,$senderId,$code);
                    file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send product weight in this format 'admin weight:20gmm' "  );
                    exit(0);
                 }
            }
        }

        //
        if(strpos($message,'admin weight:') !== false){
            $check_session = check_admin_upload_chat_id($conn,$senderId);
            if($check_session == 0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please start a upload session first with this command 'admin upload product'");
                exit(0);
            }else{

                 $split_text = preg_split('/:/',$message);
                 if($split_text[0] == "admin weight"){
                    $weight = $split_text[1];
                    save_product_weight($conn,$senderId,$weight);
                    file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Enter Product category in this format 'admin category:necklace'   "  );
                    exit(0);
                 }
            }
        }

         //
         if(strpos($message,'admin category:') !== false){
            $check_session = check_admin_upload_chat_id($conn,$senderId);
            if($check_session == 0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please start a upload session first with this command 'admin upload product'");
                exit(0);
            }else{

                 $split_text = preg_split('/:/',$message);

                 if($split_text[0] == "admin category"){
                    $category = str_replace(' ','', $split_text[1]);
                    save_product_category($conn,$senderId,$category);
                    file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Upload session is complete save this session with this command 'admin save upload'  "  );
                    exit(0);
                 }
            }
        }
        

         //
         if(strpos($message,'admin save upload') !== false){
            $check_session = check_admin_upload_chat_id($conn,$senderId);
            if($check_session == 0){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please start a upload session first with this command 'admin upload product'");
                exit(0);
            }else{

               
                $upload = fetch_upload_to_save($conn,$senderId);
                $photo = $upload['photo'];
                $weight = $upload['weight'];
                $category = $upload['category'];
                $product_code = $upload['product_code'];
                upload_to_catalog($conn,$photo,$weight,$product_code,$category);
                delete_upload_session($conn,$senderId);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Product uploaded successfully  "  );
                exit(0);
                 
            }
        }

        if(strpos($message,"admin update status:") !== false ){
            
            $data = preg_split('/:/',$text);
            $str = $data[1];
            $new_data = preg_split('/,/',$str);
            $orderid = $new_data[0];
            $orderid = str_replace(' ', '', $orderid);
            $update = $new_data[1];
            $update_order = update_order_stat($conn,$orderid,$update);
            if($update_order == 1){
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Order updated successfully ");
                exit(0);
            }else{
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Error updating pls use the right format for this command ");
                exit(0);
            }

        }
        if(strpos($message,"admin list commands") !== false || strpos($message,"admin list command") !== false  ){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= ".$list_of_admin_command);
            exit(0);

        }



       

        //AUTHENTICATED ADMIN COMMANDS HERE
    
    }else{
        //if not verified no admin command run
        file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= sorry unknown command, please use the right command and format');
        file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$welcome_msg);
        exit(0);
    }

   





}
##################################  ADMIN ENDS  #####################################################################


##################################  USER STARTS  #####################################################################
if(!empty($message) && strpos($message,"admin") === false){

    // USER COMMAND LIVES HERE
    switch ($message) {

        case '/start':
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$welcome_msg);
            exit(0); 
            # code...
            break;

        case '/customorder':
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$how_to_custom_order);
            exit(0);
            # code...
            break;

        case '/stockorder':
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text='.$how_to_catalog_order);
            sleep(4);
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= ".$category_listing);
            exit(0);
            break;
            # code...
           
        case '/orderstatus':
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= To check the status of your order send the Order Id ");
            exit(0);
            break;
            # code...

        default:
           break;
    }



    if(strpos($message,"show me") !== false){
        $split_message = preg_split('/\s+/',$message);
        if($split_message[0] == 'show' && $split_message[1] == 'me' ){
           
            $want = str_replace(' ','', $split_message[2]);
            if(in_array($want,$list_of_categories)){
                // file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Error getting order status '.$invoice_id. ' ok');
                // exit(0);
               
                $offset = 0;
                $go_back = 0;
                // $go_forward = 1;
                $catalog = send_catalog($conn,$want,$offset);
                $catalong_photo = $catalog['photo_id'];
                $catalog_weight = $catalog['weight'];
                $product_code = $catalog['product_code'];
                
                $cap = urlencode("Product code:$product_code\nProduct weight:$catalog_weight");
               
                $keyboard = keyBoard($want,$offset,$go_back);
                file_get_contents($api.'/sendPhoto?chat_id='.$chatId.'&photo='.$catalong_photo."&caption=".$cap."&reply_markup=".$keyboard);
                exit(0);
            }else{
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Product category doesn't exist on our catalog");
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=".$category_listing);
                exit(0);
            }
        }
    }

    if(strpos($message,"place order") !== false){
        $check_id = create_order_session($conn,$senderId);
        if($check_id == 1){
            delete_order_session($conn,$senderId);
            add_new_order_session($conn,$senderId);
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Send a photo of what you want');
            exit(0);
        }else{
            add_new_order_session($conn,$senderId);
            file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Send a photo of what you want');
            exit(0);
            
        }
    }

        
    if(strpos($message,"order now:") !== false){
        $check_order_session =  check_order_chat_id($conn,$senderId);
        if($check_order_session == 0){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send 'Place order or place stock order' to start a order session  ");
            exit(0);
        }
        $split_text = preg_split('/:/',$message);
        $orderId = $split_text[1];
        $orderId = str_replace(' ', '', $orderId);
        $fetched_details = fetch_order_details($conn,$senderId,$orderId);
        if($fetched_details == 0){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please check that you've entered the correct ID and also in the right format");
            exit(0);
        }
        $invoice_id = $fetched_details['invoice_id'];
        $photo_id = $fetched_details['order_photo'];
        $photo_id2 = $fetched_details['photo_id_2'];
        $branch_name = $fetched_details['branch_name'];
        $length = $fetched_details['length'];
        $remarks = $fetched_details['remark'];
        $weight = $fetched_details['weight'];
        $due_date = $fetched_details['due_date'];
        $product_code = $fetched_details['product_code']??'nulled';
        $img_link = download_image_link($photo_id);
        $img_link2 = download_image_link($photo_id2);
        $img_location = download_image_to_server($img_link,$invoice_id);
        if($img_link2 != 'not available'){
            $u = $invoice_id.'-2';
            $img_location2 = download_image_to_server($img_link2,$u);
        }
        
        create_invoice($conn,$chatId,$invoice_id,$photo_id,$weight,$branch_name,$length,$remarks,$due_date,$product_code,$img_location,$img_location2);
        delete_order_session($conn,$senderId);
        file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text=Order received your ID is '.$invoice_id.' you can use this to track your order. Select /orderstatus to know how');
        exit(0);
    }

    if(strpos($message,'place stock order') !== false){
        $check_id = create_order_session($conn,$senderId);
        if($check_id == 1){
            delete_order_session($conn,$senderId);
            add_new_order_session($conn,$senderId);
            $step = 24;
            update_steps($conn,$senderId,$step);
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please Send the product code of your choice  ");
            exit(0);
        }else{
            add_new_order_session($conn,$senderId);
            $step = 24;
            update_steps($conn,$senderId,$step);
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please Send the product code of your choice  ");
            exit(0);
            
        }
        
    }


}

if($photo != null ){
    $check_order_session =  check_order_chat_id($conn,$senderId);
    if($check_order_session == 0){
        file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send 'Place order or place stock order' to start a order session  ");
        exit(0);
    }
    $step = count_steps($conn,$senderId);
    if($step == 1){
        $step = $step +1;
        save_order_image2($conn,$senderId,$photo,$step);
        file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please Send Weight");
        exit(0);
    }
    if($step > 1){
        file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= oops!.. Order session has been disrupted, please send the command 'place order' or 'place stock order' to start a new order session ");
        exit(0);
    }
    $step = $step +1;
    save_order_image($conn,$senderId,$photo,$step);
    file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Send a second photo of what you need if available or if not send no  ");
    exit(0);
    

}

if($message != null && strpos($message,'admin') === false){
    if(!in_array($message,$special_commands)){
        $check_order_session =  check_order_chat_id($conn,$senderId);
        $invoice_id = strval($text);
        $stats = fetch_order_stats($conn,$invoice_id);
        if($check_order_session == 0 && $stats < 1){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= If you want to place an order please send 'Place order or place stock order' to start a order session  ");
            exit(0);
        }
        $step = count_steps($conn,$senderId);

        if($step < 1  && $stats < 1){
            file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= oops!.. Order session has been disrupted, please send the command 'place order' or 'place stock order' to start a new order session ");
            exit(0);
        }
       


        switch ($step) {
            case '1':
                $img_2 = $message;
                $step = $step + 1;
                save_order_image2($conn,$senderId,$img_2,$step);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send weight");
                exit(0);
                break;
            

            case '2':
                $weight = $message;
                $step = $step + 1;
                save_order_weight($conn,$senderId,$weight,$step);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send Branch Name   ");
                exit(0);
                break;
               
            case '3':
                $branch_name = $message;
                $step = $step + 1;
                save_order_branchname($conn,$senderId,$branch_name,$step);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Please send the lenght/size  needed  ");
                exit(0);
                break;

            case '4':
                $size = $message;
                $step = $step + 1;
                save_order_size($conn,$senderId,$size,$step);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please send a remark  or if no remarks send 'no remark' ");
                exit(0);
                break;

            case '5':
                $remark = $message;
                $step = $step + 1;
                save_order_remark($conn,$senderId,$remark,$step);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please send due date of choice  ");
                exit(0);
                break;

            case '6':
                $due = $message;
                $step = $step + 1;
                save_order_due($conn,$senderId,$due,$step);
                $invoice_id = create_invoice_id($conn);
                save_order_invoice_id($conn,$senderId,$invoice_id);
                $keyboard = order_keyboard($invoice_id);
                file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= you've created a new order with Invoice Id ( ".$invoice_id." ) make choice about your new order &reply_markup=".$keyboard);
                exit(0);
               
                break;

            // case '6':
            //     $img_2 = $message;
            //     save_order_image2($conn,$senderId,$img_2,$step);
            //     save_order_image2($conn,$senderId,$photo,$step);
            //     $invoice_id = create_invoice_id($conn);
            //     save_order_invoice_id($conn,$senderId,$invoice_id);
            //     $keyboard = order_keyboard($invoice_id);
            //     file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= you've created a new order with Invoice Id ( ".$invoice_id." ) make choice about your new order &reply_markup=".$keyboard);
            //     exit(0);
            
                
            case '24':
                $code = str_replace(' ','',$message);
                $product_details = check_if_product_code_exist($conn,$code);
                $pro_count = $product_details[0];
                $photo = $product_details[1];
                $weight = $product_details[2];
                if($pro_count < 1){
                    file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text= Invalid product ID or command Format. Please use the right command format to order or a correct product code ");
                    exit(0);
                }else{
                    save_order_image($conn,$senderId,$photo,$step);
                    save_order_weight($conn,$senderId,$weight,$step);
                    save_order_product_code($conn,$senderId,$code,$step);
                    $step = 3;
                    update_steps($conn,$senderId,$step);

                    file_get_contents($api.'/sendMessage?chat_id='.$chatId."&text=Please Send Branch Name");
                    exit(0);
            
                }


                break;
            
            default:
                # code...
                break;
        }
    }

}







if(strpos($message,strtolower("make admin AHSJSKoindhbd76979ajmjnklsjd/../.dddww32")) !== false){
    make_admin_account($conn,$senderId);
    file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= This account has been made the admin account to SKJ ORDER BOT');
    exit(0);
}

if(strpos($message,"check order status:") !== false || $text != null){
    $query = $text;
  
    $invoice_id = strval($query);
    $stats = fetch_order_stats($conn,$invoice_id);
    if($stats == 0){
        file_get_contents($api.'/sendMessage?chat_id='.$chatId.'&text= Error getting order status '.$invoice_id. ' Please make use of a correct command format with a correct order ID i.e (check order status:S010OP(Order ID)');
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




##################################  USER ENDS  #####################################################################


//bot logic ends here