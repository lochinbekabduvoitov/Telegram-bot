<?php

$user_id = 12345;
// Задаем нужные параметры API Telegram.
$token = '6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg';
$chat_id = 'YOUR-CHAT-ID';
// Формируем URL с API Telegram.
$url = "https://api.telegram.org/bot". $token ."/getChatMembersCount?chat_id=". $chat_id;
// Отправляем GET-запрос API Telegram.
$result = file_get_contents($url);
// Получаем JSON-ответ API Telegram.
$result = json_decode($result);
// Получаем список ID участников.
$members = $result->result;
// Проверяем, является ли ID юзера, чью роль мы хотим проверить, участником канала.  
if (in_array($user_id, $members)) {  
    echo 'User is a member of the channel.';  
} else {  
    echo 'User is not a member of the channel.';  
}

// include 'Telegram.php';

// $telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

// $chat_id = $telegram->ChatID();
// $text=$telegram->Text();

// if($text == '/start'){

    // $option = array( 
        //First row
        // array($telegram->buildKeyboardButton("Batafsil"), $telegram->buildKeyboardButton("Zakaz berish")));
        //Second row 
        
        
    // $keyb = $telegram->buildKeyBoard($option, $onetime=true,$resize=true);
    // $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Assalomu alaykum. Botimizga xush kelibsiz! Bizning kanalimizga a'zo");
    // $telegram->sendMessage($content);

    
    // }

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

