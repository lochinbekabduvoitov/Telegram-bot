<?php

include 'Telegram.php';

$telegram = new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$chat_id = $telegram->ChatID();
$text=$telegram->Text();
if($text == '/start'){

    $option = array( 
        //First row
        array($telegram->buildKeyboardButton("😊 Batafsil malumot!")), 
        //Second row 
        array($telegram->buildKeyboardButton("🤣 Buyrutma berish"), ));
       
       

    $keyb = $telegram->buildKeyBoard($option, $onetime=true,$resize=true);

    $content = array('chat_id' => $chat_id,  'text' => 'Assalomu alaykum. Botimizga xush kelibsiz! Bizning kanalimizga a\'zo  ');
    $telegram->sendMessage($content);

    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illum repudiandae eaque debitis voluptates possimus corrupti autem, vel, ipsam quo maxime non praesentium dolore deserunt, sapiente ut fugiat hic! Perspiciatis, perferendis');
    $telegram->sendMessage($content);
}elseif($text == '😊 Batafsil malumot!'){
    $content = array('chat_id' => $chat_id,  'text' => 'Batafsil malumotni saytdan oling. lochinbek.uz');
    $telegram->sendMessage($content);
}
