<?php

require_once 'db_connect.php';

include 'Telegram.php';

$telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$data = $telegram->getData();
$message= $data['message'];

// $telegram->sendMessage([
//     'chat_id' => $telegram->ChatID(),
//     'text' => json_encode($data, JSON_PRETTY_PRINT)
// ]);

$chat_id = $message['chat']['id'];
$text=$message['text'];
$filePath='users/step.txt';




$orderTypes=["1 kg - 100000" , "2 kg - 200000" ,"3 kg - 300000","4 kg - 400000"];

switch($text){
    case "/start":
        showstart();
        break;
    case "Batafsil ma\'lumot":
        showabout();
        break;
    case "Zakaz berish";
        showOrder();
        break;
    case 'back':
        switch (file_get_contents($filePath)){
            case 'start':
                break;
            case 'order':
                showstart();
                break;
        }
        break;
    default: 
        if(in_array($text, $orderTypes)){
            file_put_contents('users/massa.txt', $text);
        showAsk();
        } else {
            switch (file_get_contents('users/step.txt')){
                case 'phone':
                    if($message['contact']['phone_number'] != ''){
                        file_put_contents('users/phone.txt', $message['contact']['phone_number']);
                    }else{
                        file_put_contents('users/phone.txt', $text);
                    }
                    showDelivryType();
                    break;

            }
        };
        break;
    
}


function showstart(){
      global $telegram ,$chat_id ,$filePath; 

      file_put_contents($filePath ,'order');

    $option = [ 
        array($telegram->buildKeyboardButton("Batafsil ma'lumot")),
       array($telegram->buildKeyboardButton("Zakaz berish"))
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Assalomu alaykum bot xush kelibsiz !");
    $telegram->sendMessage($content);
}
function  showabout(){
    global $telegram, $chat_id;
    $option = [
        array($telegram->buildKeyboardButton("Saytga ulaning"))
    ];

    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "ma'lumotlarni quyidagi saytdan olishingiz mumkin lochinbek.uz");
    $telegram->sendMessage($content);
}
function showOrder(){

    global $telegram , $chat_id;

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
  
    file_put_contents('users/step.txt','phone');

    $option = array( 
        array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Hajm tanlandi bog'lanish uchun raqamingiz yuboring");
    $telegram->sendMessage($content);
}
function showDelivryType(){
    global $telegram , $chat_id;

    file_put_contents('users/step.txt','location');

    $option = array( 
        array($telegram->buildKeyboardButton("Lokatsiyangizni yuboring", $request_location= true )), 
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Murojatingiz  muvaffaqqiyatli qabul qilindi");
    $telegram->sendMessage($content);
}

printAllData();



function printAllData(){

    global $db;

   $result = $db->query("SELECT * FROM `users` ");

   while($arr = $result->fetch_assoc()){

    $natija = json_encode($arr, JSON_PRETTY_PRINT);
    print $natija;
    // if(isset($arr['data_json'])){
    //     print $arr['data_json'];
    //     print "<br/>";
    // }
   }
}


