<?php


include 'Telegram.php';

$telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$data = $telegram->getData();

$telegram->sendMessage([
    'chat_id' => $telegram->ChatID(),
    'text' => json_encode($data, JSON_PRETTY_PRINT)
]);

$chat_id = $telegram->ChatID();
$text=$telegram->Text();




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
    default: 
        if(in_array($text, $orderTypes)){
            file_put_contents('users/massa.txt', $text);
        showAsk();
        } else {
            switch (file_get_contents('users/step.txt')){
                case 'phone':
                    file_put_contents('users/phone.txt', $text);
                    showDelivryType();
                    break;

            }
        };
        break;
    
}


function showstart(){
      global $telegram ,$chat_id;

    $option = [ 
        array($telegram->buildKeyboardButton("Batafsil ma'lumot")),
       array($telegram->buildKeyboardButton("Zakaz berish"))
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Assalomu alaykum bot xush kelib siz");
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
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Qancha zakaz berasiz hurmatli mijoz");
    $telegram->sendMessage($content);
}
function showAsk(){
    global $telegram , $chat_id;

    file_put_contents('users/step.txt','phone');

    $option = array( 
        array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "hajm tanlandi Bog'lanish uchu raqamingiz yuboring");
    $telegram->sendMessage($content);
}
function showDelivryType(){
    global $telegram , $chat_id;

    // file_put_contents('users/step.txt','phone');

    // $option = array( 
    //     array($telegram->buildKeyboardButton("Tel yub" )), 
    // );
    // $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    // $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "hajm tanlandi Bog'lanish uchu raqamingiz yuboring");
    // $telegram->sendMessage($content);
}


// elseif
// elseif($text =='Batafsil'){

//     $option = array( 
//          array($telegram->buildKeyboardButton("Saytga ulanish")) );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=false ,$resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Nima gap");
//     $telegram->sendMessage($content);
// }elseif($text =='Zakaz berish'){

//     $option = array( 
//          array($telegram->buildKeyboardButton("1-kg")),$telegram->buildKeyboardButton("2-kg") );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=false ,$resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Nima gap");
//     $telegram->sendMessage($content);
// }

// elseif($text == 'Batafsil'){

//     $option = array( 
//         array($telegram->buildKeyboardButton("Saytga ulanish")));
//     $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Szi batafsil bo'limini bosdingiz lochinbek.uz");
//     $telegram->sendMessage($content);

// }elseif($text == 'Zakaz berish'){

//     $option = array( 
//         array($telegram->buildKeyboardButton("1 kg - 100000"), $telegram->buildKeyboardButton("2 kg - 200000")), 
//         array($telegram->buildKeyboardButton("3 kg - 300000"), $telegram->buildKeyboardButton("4 kg - 400000")), 
//     );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Qancha zakaz berasiz");
//     $telegram->sendMessage($content);

// }
// elseif($text == '1 kg - 100000'){
//     $option = array( 
//         array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
//     );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Bog'lanish uchu raqamingiz yuboring");
//     $telegram->sendMessage($content);
// }elseif($text == '2 kg - 200000'){
//     $option = array( 
//         array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
//     );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Bog'lanish uchu raqamingiz yuboring");
//     $telegram->sendMessage($content);
// }elseif($text == '3 kg - 300000'){
//     $option = array( 
//         array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
//     );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Bog'lanish uchu raqamingiz yuboring");
//     $telegram->sendMessage($content);
// }elseif($text == '4 kg - 400000'){
//     $option = array( 
//         array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
//     );
//     $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
//     $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Bog'lanish uchu raqamingiz yuboring");
//     $telegram->sendMessage($content);
// }

