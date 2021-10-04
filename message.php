<?php

$welcome_msg_txt = <<<WELCOME
Hello, Welcome to SKJ ORDERS BOT. Select a command from the menu to get information on how to 
use this bot.
or select from here. 
(1)How to place custom order /customorder 
(2) How to place stock order /stockorder 
(3) How to check order status /orderstatus 
WELCOME;


$welcome_msg = urlencode($welcome_msg_txt);
$help_msg = urlencode($welcome_msg_txt);

$how_to_custom_order_txt = <<<CUSTOM
To place a custom order send the command "place order" to initiate a order session and get your invoice id
Please use the right format and order. Details to be provided
Branch name
Weight
Length/Size
Remarks
Due Date.
Once all information are submitted send "Order now:The Invoice Id you recieved" to complete the order
CUSTOM;
$how_to_custom_order = urlencode($how_to_custom_order_txt);


$how_to_catalog_order_txt = <<<CATALOG
You will receive a list of our stock categories to choose from.
Send the following command, to browse through the category you want to see "show me THE CATEGORY NAME", "i.e(show me necklace)"

When you see what you like you can order it by sending the following message to the bot "place stock order" to start a order session submitted all details as requested
CATALOG;
$how_to_catalog_order = urlencode($how_to_catalog_order_txt);

$catalog_order_img_sample = "AgACAgQAAxkBAAIDTWEaaoWeqmBEggie2rlf0iHaQlVdAAIjuDEb9unZUEPtlZJTRrdEAQADAgADeQADIAQ";

$category_listing = urlencode("1.Necklace\n2.Bangles\n3.Set\n4.Niddle\n5.Nakash\n6.Haaram\n7.Earings\n8.Choker\n9.Casting\n10.Others"  );


$admin_command_help = "As an admin to upload to catalog send the bot a picture of the product with the product code and weight in the caption make sure it is in this format PRODUCT CODE:B002 go to new line WEIGHT:20.00gms";
$list_of_admin_command_txt = <<<ADMINCOMMANDS
ALWAYS USE THE CORRECT COMMAND OR FORMAT TO PERFORM ADMIN ACTIONS!!

To update order status use command "Admin update status:ORDER ID,NEW STATUS"
To upload a product use command "Admin upload product" to start a upload session, use "admin save upload" to complete upload session
ADMINCOMMANDS;

$list_of_admin_command = urlencode($list_of_admin_command_txt);




function keyBoard($want,$offset,$go_back){

    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => 'BACK', 'callback_data' => $want.' back '.$go_back],
                ['text' => 'NEXT', 'callback_data' => $want.' next '.$offset]
               
            ]
            
        ]
    ];
    $keyboard = json_encode($keyboard);
    return $keyboard;
}


function order_keyboard($invoice_id){
    $keyboard = [
        'inline_keyboard' => [
            [
                ['text' => 'ORDER', 'callback_data' => "order now:".$invoice_id],
                ['text' => 'CANCEL SESSSION', 'callback_data' => "Cancel order"]
               
            ]
            
        ]
    ];
    $keyboard = json_encode($keyboard);
    return $keyboard;
}