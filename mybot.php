<?php

require_once 'Telegram.php';

require_once 'user.php';

$telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$data = $telegram->getData();
$message= $data['message'];



$chat_id = $message['chat']['id'];

$text=$message['text'];

if($text == '/start'){
       showMain();
}else{
    switch(getPage($chat_id)){
        case 'main';
            if($text= "Batafsil ma'lumot"){
                showabout();
            }elseif($text= "Zakaz berish"){
                showOrder();
            }else{
                chooseButton();
            }
            break;
    }
}

function showMain(){
    global $telegram ,$chat_id ,$filePath; 

    setPage($chat_id, 'main');

  $option = [ 
      array($telegram->buildKeyboardButton("Batafsil ma'lumot")),
     array($telegram->buildKeyboardButton("Zakaz berish"))
  ];
  $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
  $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Assalomu alaykum bot xush kelibsiz !");
  $telegram->sendMessage($content);
}

function chooseButton(){

    global $telegram ,$chat_id;
    
    $content = ['chat_id'=>$chat_id, 'text'=> 'iltimos quyidagi tugmalardan birini tanlang'];
    $telegram->sendMessage($content);
}
