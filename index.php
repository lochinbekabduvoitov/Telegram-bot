<?php

include 'Telegram.php';

$telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$chat_id = $telegram->ChatID();
$text=$telegram->Text();

if($text == '/start'){
    showStart();
}elseif($text == 'Batafsil'){
    showAbout();
}elseif($text == 'Zakaz berish'){
  
}elseif($text == '1 kg - 100000'){
    askContact();
}elseif($text == '2 kg - 200000'){
    askContact();
}elseif($text == '3 kg - 300000'){
    askContact();
}elseif($text == '4 kg - 400000'){
    askContact();
}


function showStart(){

    global $telegram,$chat_id;

    $option = array( 
        array($telegram->buildKeyboardButton("Batafsil")),
        array($telegram->buildKeyboardButton("Zakaz berish")));

    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);

    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Assalomu alaykum. Botimizga xush kelibsiz! Bizning kanalimizga a'zo");
    $telegram->sendMessage($content);
};

function showAbout(){
    global $telegram , $chat_id;
    $option = array( 
        array($telegram->buildKeyboardButton("Saytga ulanish")));
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Szi batafsil bo'limini bosdingiz lochinbek.uz");
    $telegram->sendMessage($content);
};

function showOrder(){
    global $telegram , $chat_id;
    $option = array( 
        array($telegram->buildKeyboardButton("1 kg - 100000"), $telegram->buildKeyboardButton("2 kg - 200000")), 
        array($telegram->buildKeyboardButton("3 kg - 300000"), $telegram->buildKeyboardButton("4 kg - 400000")), 
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Qancha zakaz berasiz");
    $telegram->sendMessage($content);
};

function askContact(){

    global $telegram , $chat_id;

    $option = array( 
        array($telegram->buildKeyboardButton("Raqamni yuborish" , $request_contact= true)), 
    );
    $keyb = $telegram->buildKeyBoard($option, $onetime=true, $resize=true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Bog'lanish uchu raqamingiz yuboring");
    $telegram->sendMessage($content);

};