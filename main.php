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
}else{
    switch(getPage($chat_id)){
        case 'main':
            if($text == "🍯 Batafsil ma'lumot"){
                showAbout();
            }elseif($text == "🍯 Buyurtma berish"){
                showMass();
            }else{
                chooseButtons();
            }
        break;
        case 'massa':
            if(in_array($text, $orderTypes)){
                setMass($chat_id,$text);
                showPhone();
            }elseif($text = "🔙 Orqaga"){
                showMain();
            }else{
                chooseButtons();
            }
        break;
    }
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
    Ushbu bot orqali siz BeeO asal-arichilik firmasidan tabiiy asal va  asal mahsulotlarini sotib olishingiz mumkin!");
    $telegram->sendMessage($content);
    $content = array('chat_id' => $chat_id, 'disable_web_page_preview' => false, 'reply_markup' => $keyb, 'text' => "Mening ismim Jamshid, ko`p yillardan beri oilaviy arichilik bilan shug`illanib kelamiz!
    BeeO -asalchilik firmamiz mana 3 yildirki, Toshkent shahri aholisiga toza, tabiiy asal yetkizib bermoqda va ko`plab xaridorlarga ega bo`ldik, shukurki, shu yil ham arichiligimizni biroz kengaytirib siz azizlarning ham dasturxoningizga tabiiy-toza asal yetkazib berishni niyat qildik!");
    $telegram->sendMessage($content);
}



function showMass(){
    global $telegram, $chat_id, $filePath;

    $option=[
        [$telegram->buildKeyboardButton("1kg - 50 000 so'm")],
        [$telegram->buildKeyboardButton("1.5kg (1L) - 75 000 so'm")],
        [$telegram->buildKeyboardButton("4.5kg (3L) - 220 000 so'm")],
        [$telegram->buildKeyboardButton("7.5kg (5L) - 370 000 so'm")],
        [$telegram->buildKeyboardButton("🔙 Orqaga")],
    ];
    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => "Buyurtma berish uchun hajmlardan birini tanlang yoki o'zingiz hohlagan hajmni kiriting.");
    $telegram->sendMessage($content);
}

function showPhone(){
    global $telegram ,$chat_id;

    setPage($chat_id,'phone');

    $option=[
        array($telegram->buildKeyboardButton("Raqamni jo'natish", $request_contact = true)),
        array($telegram->buildKeyboardButton("🔙 Orqaga"))
    ];

    $keyb = $telegram->buildKeyBoard($option, $onetime = false, $resize = true);
    $content = array('chat_id' => $chat_id, 'reply_markup' => $keyb, 'text' => 'Hajm tanlandi, endi telefon raqamingnizni kiritsangiz.');
    $telegram->sendMessage($content);
}

function showAbout(){
    global $telegram, $chat_id;
    $content=[
        'chat_id'=>$chat_id,
        'text'=>"Biz haqimizda ma'lumot. <a href='https://telegra.ph/Biz-haqimizda-05-12'>Havola</a>",
        'parse_mode' => "html"
    ];
    $telegram->sendMessage($content);
}

function chooseButtons(){
    global $telegram, $chat_id;

    $content=[
        'chat_id'=>$chat_id,
        'text'=> "Iltimos quyidagi tugmalardan birini tanlang."
    ];
    $telegram->sendMessage($content);
}
