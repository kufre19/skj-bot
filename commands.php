<?php


$user_commands = array('/customorder','/stockorder','/orderstatus');
$user_order_command = array('weight','remark');
$admin_command = array('make admin');

$list_of_categories = array('necklace','bangles','bangle','set','niddle','nakash','haaram','earings','chokers','choker','casting','others','other');
$admin_id = '1324611645';

$admin_key = "AHSJSKoindhbd76979ajmjnklsjd/../.dddww32";

$special_commands = array('place order','place stock order','order now:','check status:');

function download_image_to_server($img_link,$invoice_id){
    $ext = '';
    if(strpos($img_link,".jpg") !== false){
        $ext = ".jpg";
    }

    if(strpos($img_link,".png") !== false){
        $ext = ".png";
    }

    if(strpos($img_link,".jpeg") !== false){
        $ext = ".jpeg";
    }

    $new_name = $invoice_id.$ext;
    $dir = "order_images/";
    $location = $dir.$new_name;
    $f = fopen($location,'w');
    fclose($f);

    

    switch ($ext) {
        case '.jpg':
            $gee = imagecreatefromjpeg($img_link);
            imagejpeg($gee, $dir.$new_name);
            return $location;
            break;

        case '.png':
            $gee = imagecreatefrompng($img_link);
            imagepng($gee, $dir.$new_name);
            return $location;
            break;
        
        default:
            # code...
            break;
    }



   

}