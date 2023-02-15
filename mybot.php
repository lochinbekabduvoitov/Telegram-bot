<?php

require_once 'Telegram.php';

require_once 'user.php';

require_once 'db_connect.php';

$telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$data = $telegram->getData();
$message= $data['message'];



$chat_id = $message['chat']['id'];

$text=$message['text'];

$orderTypes=["1 kg - 100000" , "2 kg - 200000" ,"3 kg - 300000","4 kg - 400000"];

if($text == '/start'){
       showMain();
}else{
    switch(getPage($chat_id)){
        case 'main';
            if($text == "Batafsil ma'lumot"){
                showabout();
            }elseif($text == "Zakaz berish"){
                showOrder();
            }else{
                chooseButton();
            }
            break;
        case 'massa':
            if(in_array($text, $orderTypes)){
                setMassa($chat_id, $text);
                // showAsk();
            }elseif($text == 'back'){
                showMain();
            }else{
                chooseButton();
            }
            break;
        case 'phone':
                if($message['contact']['phone_number'] != ''){
                    file_put_contents('users/phone.txt', $message['contact']['phone_number']);
                }elseif($text == 'back'){
                    // showOrder();
                }else{
                    chooseButton();
                }
                break;
    }
}

function showMain(){
    global $telegram ,$chat_id,$filePath; 

    setPage($chat_id, 'main');

  $option = [ 
      array($telegram->buildKeyboardButton("Batafsil ma'lumot")),
     array($telegram->buildKeyboardButton("Zakaz berish"))
  ];
  $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
  $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Assalomu alaykum!");
  $telegram->sendMessage($content);
}

function chooseButton(){

    global $telegram ,$chat_id;
    
    $content = ['chat_id'=>$chat_id, 'text'=> 'iltimos quyidagi tugmalardan birini tanlang'];
    $telegram->sendMessage($content);
}


function showOrder(){

    global $telegram , $chat_id;

    setMassa($chat_id, 'massa');

    $option = [
        array($telegram->buildKeyboardButton("1 kg - 100000"), $telegram->buildKeyboardButton("2 kg - 200000")), 
        array($telegram->buildKeyboardButton("3 kg - 300000"), $telegram->buildKeyboardButton("4 kg - 400000")),
        array($telegram->buildKeyboardButton("back")),
        
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Qancha zakaz berasiz hurmatli mijoz");
    $telegram->sendMessage($content);
}


function showAsk(){
    global $telegram , $chat_id ,$message;
  
    setMassa($chat_id, 'massa');

    $option = array( 
        array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Hajm tanlandi bog'lanish uchun raqamingiz yuboring");
    $telegram->sendMessage($content);
}
