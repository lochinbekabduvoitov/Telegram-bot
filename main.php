<?php

require_once 'Telegram.php';
require_once 'user.php';

$telegram =new Telegram('6146306512:AAGVdpKHJ-VGyu1D2Oc1q6T8xl4nMN1WTrg');

$ADMIN_CHAT_ID = 1652305676;

$data= $telegram->getData();

$message = $data['message'];


$text = $message['text'];
$chat_id = $message['chat']['id'];
$firstName=$message['from']['first_name'];
$lastName=$message['from']['last_name'];

$orderTypes = ["1kg - 50 000 so'm", "1.5kg (1L) - 75 000 so'm", "4.5kg (3L) - 220 000 so'm", "7.5kg (5L) - 370 000 so'm"];

if($text == "/start"){
    showMain();
}


//Functions

function showMain(){
    global $telegram, $chat_id, $firstName, $lastName;

    setPage($chat_id, 'main');

    $option = array(
        //First row
        array($telegram->buildKeyboardButton("🍯 Batafsil ma'lumot")),
        //Second row
        array($telegram->buildKeyboardButton("🍯 Buyurtma berish"))
    );

    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'text' => "Assalom alaykum, {$firstName} {$lastName}!
    Ushbu bot orqali siz Lalaku asal-arichilik firmasidan tabiiy asal va  asal mahsulotlarini sotib olishingiz mumkin!");
    $telegram->sendMessage($content);
    $content = array('chat_id' => $chat_id, 'disable_web_page_preview' => false, 'reply_markup' => $keyb, 'text' => "Mening ismim Hamid, ko`p yillardan beri oilaviy arichilik bilan shug`illanib kelamiz!
    Lalaku -asalchilik firmamiz mana 3 yildirki, Toshkent shahri aholisiga toza, tabiiy asal yetkizib bermoqda va ko`plab xaridorlarga ega bo`ldik, shukurki, shu yil ham arichiligimizni biroz kengaytirib siz azizlarning ham dasturxoningizga tabiiy-toza asal yetkazib berishni niyat qildik!");
    $telegram->sendMessage($content);

}