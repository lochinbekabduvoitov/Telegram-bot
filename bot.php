<?php
//require 'vendor/autoload.php';
//use Symfony\Component\DomCrawler\Crawler;
$token = 'Token'; // 

//https://api.telegram.org/botTOKEM/setWebhook?url=URL


$ownerOfBot = 0; //enter user id of your telgram account.

$savefilePath = realpath(dirname(__FILE__) . '/files');
$currentPath="chatBot/tmp";
$siteUrl = "URL";
$botName = "BOTNAMEBOT";

$servername = "servername";
$db_username = "db_username";
$password = "password";
$dbname = "dbname";

// // read incoming info and grab the chatID 
// $json = file_get_contents('php://input');
// $telegram = urldecode ($json);
// // $telegram = str_replace ('jason=','',$telegram); //Just for Teletter.net
// $results = json_decode($telegram); 
// send reply
//   $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id=0000000000&text='.$json;
//   file_get_contents($url);
// read incoming info and grab the chatID 
$json = file_get_contents('php://input');
$telegram = urldecode ($json);
// $telegram = str_replace ('jason=','',$telegram); //Just for Teletter.net
$results = json_decode($telegram);
//file_put_contents(realpath(dirname(__FILE__) . '/log.txt'), $results,FILE_APPEND);
//echo getcwd();
$update_id = $results->update_id;
//$inline_query = $results->inline_query;
$message = $results->message;
$message_id = $message->message_id;
//from user
$fromuser = $message->from;
$user_id = $fromuser->id;
$username = $fromuser->username;
$user_first_name = $fromuser->first_name;
$fromuser_language_code = $fromuser->language_code;
$chat = $message->chat;
$chat_id = $chat->id;
$chat_title = $chat->title;
$chat_type = $chat->type;
$chat_username = $chat->username;
$chat_invite_link = $chat->invite_link;
$forward_from = $message->forward_from;
$forward_from_id = $forward_from->id;
$forward_from_name = $forward_from->first_name;
$forward_from_chat = $message->forward_from_chat;
$forward_from_chat_id = $forward_from_chat->id;
$forward_from_chat_title = $forward_from_chat->title;
$forward_from_chat_username = $forward_from_chat->username;
$forward_from_chat_type = $forward_from_chat->type;
$forward_date = $message->forward_date;


$reply_to_message = $message->reply_to_message;


$text = $message->text;
$caption = $message->caption;
$photo = $message->photo;
$video = $message->video;
$audio = $message->audio;
//$file = $message->file;
//Get Bot Data
$about = getMe($token);
$me = json_decode ($about);
$me = $me->result;
$me_username = $me->username;
$forward_from_message_id = $message->forward_from_message_id;
//send_group_message($chat_id,$token,$telegram);
$fee = "";
$isFree = true;
$blnContinue;
$blnSetPrivilege;
// $default for using nolink noatsing , ... must be false, dafualt is true.
$default = true;

//$users = [[ 0000000,  "yasi", "$siteUrl/$currentPath/0000000.jpg"], [0000000, "Yousef B", "$siteUrl/$currentPath/0000000.jpg"],[]];
//$users = [ ]
if(isset($results->callback_query)){
    makeHTTPRequest($token,'answerCallbackQuery',[
        'callback_query_id'=>$results->callback_query->id,
        'text'=>"You accept to start a chat.",
    ]);
    if($results->callback_query->data == 1){
        $newChatId = $results->callback_query->message->chat->id;
        $messageId = $results->callback_query->message->message_id;
        makeHTTPRequest($token,'editMessageText',['chat_id' => $newChatId,'message_id' => $messageId ,'text' =>"https://t.me/$botName?start=$newChatId"]);    }

}

if (isset($results->inline_query)) {
    $inline_query = $results->inline_query;
    $query_Id = $inline_query->id;
    $query_Text = $inline_query->query;
//    makeHTTPRequest($token, "sendMessage",['chat_id' => $user_id, 'text' => $query_Text ] );
    if (isset($query_Text) && $query_Text !== "") {
//        makeHTTPRequest($token, "answerInlineQuery",[
//            "inline_query_id" => $query_Id,
//            "results" => json_encode(queryDuckDuckGo($query_Text)),
//            "cache_time" => 10,
//        ]);


//        makeHTTPRequest($token, "answerInlineQuery",[
//            "inline_query_id" => $query_Id,
//            "results" => json_encode([[
//                "type" => "article",
//                "id" => "0",
//                "title" => "Service unavailable",
//                "input_message_content" => ["message_text" => "Service unavailable",
//                    "parse_mode" => "HTML"] ,
//            ]]),
//            "cache_time" => 10,
//        ]);

    } else {


//        $p1=smallPhotoProfileFileID (000000000,$token);
//        $p2=smallPhotoProfileFileID (00000000,$token);
//        $users = [[0000000, "yasi", $p1], [0000000, "Yousef B", $p2]];

        $keyboard = array(
            array(
                array('text' => 'شماره تماس', 'url' => 'http://websima.com'),
                array('text' => 'اطلاعات', 'callback_data' => '1'),
                array('text' => 'you see', 'switch_inline_query' => 'hey jose'),
                array('text' => 'swithc inline', 'switch_inline_query_current_chat' => 'yes inline')
            ),
        );
        foreach (range(0, count($users) - 1) as $i) {
            $collection[] = [
                "type" => "article",
                "id" => "$i",
                "title" => $users[$i][1],
                "input_message_content" => ["message_text" => "http://t.me/$botName?start=".$users[$i][0],
                    "parse_mode" => "HTML"],

                "thumb_url" => $users[$i][2],
                "thumb_width" => 90,
                "thumb_height" => 90
            ];
        }

//                "reply_markup" => ["inline_keyboard" => $keyboard],
        makeHTTPRequest($token, "answerInlineQuery", [
            "inline_query_id" => $query_Id,
            "results" => json_encode($collection),
        ]);
//        "switch_pm_text" => "hisk"

    }

}elseif(isset($reply_to_message)){
//            makeHTTPRequest($token, "sendMessage",['chat_id' => $user_id, 'text' => $reply_to_message->from->id,   "parse_mode" => "HTML"  ]);
//            makeHTTPRequest($token, "forwardMessage",['chat_id' => 00000000,'from_chat_id' => $user_id, 'message_id' => $reply_to_message->message_id ]);
//    if (isset($username)){
    $repToText = $reply_to_message->text;
    $repArray = explode(";", $repToText);
    $repUserId = $repArray[0];
    $repMessageId = $repArray[1];
    $rText = explode(":", $repToText)[1];
    $rText = substr($rText,2);
//    makeHTTPRequest($token, "sendMessage",['chat_id' => $repUserId, 'text' => "repUserId : $repUserId \x0A rText : $rText"]);
    if (isset($username)){
        makeHTTPRequest($token, "sendMessage",['chat_id' => $repUserId, 'text' => "$user_id;$message_id; \x0A <a href=\"https://t.me/$username\">$user_first_name</a>  says: \x0A $text","reply_to_message_id" => $repMessageId,"parse_mode" => "HTML" ,"disable_web_page_preview" => false]);
    }else{
        makeHTTPRequest($token, "sendMessage",['chat_id' => $repUserId, 'text' =>"$user_id;$message_id; \x0A <a href=\"tg://user?id=$user_id\">$user_first_name</a>  says: \x0A $text","parse_mode" => "HTML" ,"disable_web_page_preview" => false    ]);
    }




}else {
//    makeHTTPRequest($token, "sendMessage",['chat_id' => $user_id, 'text' => $telegram ]);

    if (substr($message->text, 0, 6) == "/start" && strlen($message->text) > 6) {
        $msg = explode("/", str_replace(array("|"," "), "/", $message->text));
        makeHTTPRequest($token, "sendMessage",['chat_id' => $user_id, 'text' => 'here' ]);
        $userToChat = $msg[2];
        $keyboard = array(
            array(
                array('text' => 'yes', 'callback_data' => '1'),
                array('text' => 'no', 'callback_data' => '0'),
            ),
        );
        // ["inline_keyboard" => $keyboard]
//        $messageText = ["$users[1] wants to chat with you. do you accept?", "parse_mode" => "HTML"];
        makeHTTPRequest($token, "sendMessage",['chat_id' => $userToChat, 'text' => "$users[1] wants to chat with you. do you accept?" ,"parse_mode" => "HTML","reply_markup" => json_encode(["inline_keyboard" => $keyboard]) ]);
}else{

        if (isset($username)){
            makeHTTPRequest($token, "sendMessage",['chat_id' => $ownerOfBot, 'text' =>"$user_id;$message_id; \x0A <a href=\"https://t.me/$username\">$user_first_name</a>  says: \x0A $text","parse_mode" => "HTML" ,"disable_web_page_preview" => false    ]);
        }else{
            makeHTTPRequest($token, "sendMessage",['chat_id' => $ownerOfBot, 'text' =>"$user_id;$message_id; \x0A <a href=\"tg://user?id=$user_id\">$user_first_name</a>  says: \x0A $text","parse_mode" => "HTML" ,"disable_web_page_preview" => false    ]);
        }
        // $user_first_name  \x0A".$text

    }



    }
    /*
    switch ($chat_type) {
        case 'group':
            $blnContinue=true;
            break;
        case 'supergroup':
            $blnContinue=true;
            break;
        default:
            $blnContinue=true;
    }
    */
function smallPhotoProfileFileID ($user_id,$token){
    $offset = 0;
    $limit = 5;
    $profilephotos = getUserProfilePhotos($user_id, $offset, $limit, $token);
    // شناسایی پیام دریافتی و پیدا کردن تصاویر در آن
    $profilephotos = json_decode($profilephotos);
    $result = $profilephotos->result;
    $photos = $result->photos;
    // شرط مناسب برای چک کردن اینکه کاربر عکس داشته یا نه

    if (is_array($photos)) {
        $file_id = $photos[0][0]->file_id;
        //دریافت آدرس فایل در سرور تلگرام
        $getfile = websima_getfile($file_id, $token);
        return 'https://api.telegram.org/file/bot' . $token . '/' . $getfile;
    }

}

function getUserProfilePhotosSmallestAndSaveToServer ($user_id,$token,$savefilePath){
    $offset = 0;
    $limit = 5;
    $profilephotos = getUserProfilePhotos($user_id, $offset, $limit, $token);
    // شناسایی پیام دریافتی و پیدا کردن تصاویر در آن
    $profilephotos = json_decode($profilephotos);
    $result = $profilephotos->result;
    $photos = $result->photos;
    // شرط مناسب برای چک کردن اینکه کاربر عکس داشته یا نه

    if (is_array($photos)) {
        $file_id = $photos[0][0]->file_id;
        //دریافت آدرس فایل در سرور تلگرام
        $getfile = websima_getfile($file_id, $token);
        $fileurl = 'https://api.telegram.org/file/bot' . $token . '/' . $getfile;
        $savefile = "$savefilePath/$user_id" . "." . fileExt($getfile);
        download_file_toserver($fileurl, $savefile);
    }

}
    function queryDuckDuckGo($query)
    {

        $content = file_get_contents('https://duckduckgo.com/html/?q=' . urlencode($query));
        if (!$content) return [[
            "type" => "article",
            "id" => "0",
            "title" => "Service unavailable",
            "message_text" => "Service unavailable",
        ]];

        $crawler = new Crawler();

        $crawler->addHtmlContent($content);

        $crawler->filterXPath('//span[contains(@id, "article-")]')->evaluate('substring-after(@id, "-")');


        $results = $crawler->filter(".links_main .result__title");
        foreach ($results as $result) {
            $titles[] = trim($result->textContent);
        }

        $results = $crawler->filter(".links_main .result__snippet");
        foreach ($results as $result) {
            $snippets[] = trim($result->textContent);
        }

        $results = $crawler->filter(".links_main .result__url");
        foreach ($results as $result) {
            $urls[] = trim($result->textContent);
        }

        foreach (range(0, count($titles) - 1) as $i) {
            $collection[] = [
                "type" => "article",
                "id" => "$i",
                "title" => "$titles[$i]",
                "message_text" => "$titles[$i]\n$snippets[$i]\n$urls[$i]",
            ];
        }

        return $collection;
    }

    function makeHTTPRequest($token, $method, $datas = [])
    {
        $url = "https://api.telegram.org/bot" . $token . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            var_dump(curl_error($ch));
        } else {
            return json_decode($res);
        }
    }

    function deleteMessage($chat_id, $message_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/deleteMessage?chat_id=' . $chat_id . '&message_id=' . $message_id;
        file_get_contents($url);
    }

    function kickChatMember($user_id, $chat_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/kickChatMember?chat_id=' . $chat_id . '&user_id=' . $user_id;
        file_get_contents($url);
    }

    function unbanChatMember($user_id, $chat_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/unbanChatMember?chat_id=' . $chat_id . '&user_id=' . $user_id;
        file_get_contents($url);
    }

    function send_group_message($chat_id, $token, $message)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat_id . '&text=' . $message;
        file_get_contents($url);
    }

    function send_channel_message($chat_id, $token, $message)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $chat_id . '&text=' . $message;
        file_get_contents($url);


//  $botToken = "yourbottoken";
// $chat_id = "@yourchannel";
// $message = "your message";
// $bot_url    = "https://api.telegram.org/bot$botToken/";
// $url = $bot_url."sendMessage?chat_id=".$chat_id."&text=".urlencode($message);
// file_get_contents($url);

    }

    function getChat($chat_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/getChat?chat_id=' . $chat_id;
        $result = file_get_contents($url);
        //send_group_message($chat_id,$token,$result);
        $result = json_decode($result);
        $result = $result->result;
        return $result;
    }

    function getChatAdministrators($chat_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/getChatAdministrators?chat_id=' . $chat_id;
        $result = file_get_contents($url);
        //send_group_message($chat_id,$token,$result);
        $result = json_decode($result);
        $result = $result->result;
        return $result;
    }

    function getChatMembersCount($chat_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/getChatMembersCount?chat_id=' . $chat_id;
        $result = file_get_contents($url);
        $result = json_decode($result);
        $result = $result->result;
        return $result;
    }

    function leaveChat($chat_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/leaveChat?chat_id=' . $chat_id;
        $result = file_get_contents($url);
    }

    function getMe($token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/getMe';
        $result = file_get_contents($url);
        return ($result);
    }

// $message = $results->message;
// $text = $message->text;
// $chat = $message->chat;
// $photo = $message->photo;
// $user_id = $chat->id;
// if (is_array($photo)) {
//  $count = count ($photo)-1;
//  $fileid = $photo[$count]->file_id;
// }
//  $message = $fileid;
//  $message = urlencode($message);
// //  websima_sendmessage ($user_id,$message,$token);
//  $message = websima_getfile ($fileid,$token);
// //  websima_sendmessage ($user_id,$message,$token);
//  $fileurl = 'https://api.telegram.org/file/bot'.$token.'/'.$message;
// $len = strlen($message);
//   download_file_toserver ($fileurl,substr($message,strpos($message, "/")+1,$len));
// $content = file_get_contents($fileurl);
//    file_put_contents(substr($message,strpos($message, "/")+1,$len), $content);
//    websima_sendmessage ($user_id,$fileurl,$token);
//  $fileurl = 'https://api.telegram.org/file/bot'.$token.'/'.$message;
//   //$url_on_server = 'photo/file_30.jpg';
//   download_file_toserver ($fileurl,$message);
//   websima_sendmessage ($user_id,$message,$token);
// //add time to the current filename
// $name = basename($fileurl);
// list($txt, $ext) = explode(".", $name);
// $name = $txt.time();
// $name = $name.".".$ext;

// //check if the files are only image / document
// if($ext == "jpg" or $ext == "png" or $ext == "gif" or $ext == "doc" or $ext == "docx" or $ext == "pdf"){
// // here is the actual code to get the file from the url and save it to the uploads folder
// // get the file from the url using file_get_contents and put it into the folder using file_put_contents
// $upload = file_put_contents(__DIR__."/uploads/$name",file_get_contents($fileurl));
// //check success
// if($upload)   $finalmessage = "Success: <a href='uploads/".$name."' target='_blank'>Check Uploaded</a>"; else $finalmessage = "please check your folder permission";
// }else{
// $finalmessage = "Please upload only image/document files";
// }
//  websima_sendmessage ($user_id,'name: '.$name,$token);
//  websima_sendmessage ($user_id,'url: '.$fileurl,$token);
//  websima_sendmessage ($user_id,'path: '.__DIR__."/uploads/$name",$token);
//  websima_sendmessage ($user_id,'final message: '. $finalmessage,$token);
// $fullstring = 'this is my photos/file_1.jpg';
// // $parsed = get_string_between($message, 'p', '/');
// $len = strlen($fullstring);
// websima_sendmessage ($user_id,substr($fullstring,strpos($fullstring, "/")+1,$len-strpos($fullstring, "/")),$token);
//  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$user_id.'&text='.$message;
//  file_get_contents($url);
// $caption = 'my images';
// $photo = getcwd().'/images.jpg';
// $filename = 'images.jpg';
// websima_sendphoto($token,$user_id, $caption, $photo,$filename);
// $action = 'find_location';
// sendChatAction ($user_id,$action,$token);
// //تعیین پارامترهای دریافت عکس پروفایل
// $offset = 0;
// $limit = 5;
// //دریافت تصویر پروفایل کاربر
// $profilephotos = getUserProfilePhotos ($user_id,$offset,$limit,$token);
// // شناسایی پیام دریافتی و پیدا کردن تصاویر در آن
// $profilephotos = json_decode ($profilephotos);
// $result = $profilephotos->result;
// $photos = $result->photos;
// // شرط مناسب برای چک کردن اینکه کاربر عکس داشته یا نه
// if (is_array($photos)) {
// //ساخت دایرکتورهای مناسب برای هر کاربر
//  mkdir ($user_id);
//  mkdir ($user_id.'/photos');
// // ایجاد حلقه برای هر شناسایی هر تصویر
//  foreach ($photos as $photo) {
// //دریافت تعداد سایزهای موجود از هر عکس       
//      $count = count ($photo)-1;
//      websima_sendmessage ($user_id,$count,$token);
// //دریافت آی دی عکسی که بهترین کیفیت را دارد
//      $file_id = $photo[$count]->file_id;
//      websima_sendmessage ($user_id,$file_id,$token);
// //دریافت آدرس فایل در سرور تلگرام
//      $getfile = websima_getfile ($file_id,$token);
//      websima_sendmessage ($user_id,$getfile,$token);     
// // ساخت آدرس قابل دسترسی براساس نام فایل ساخته شده       
//      $fileurl = 'https://api.telegram.org/file/bot'.$token.'/'.$getfile;
// // تعیین مسیر صحیح برای ذخیره فایل
//      $savefile = $user_id.'/'.$getfile;
// // ذخیره تصویر از سرور تلگرام در فولدر بندی مورد نظر
//      download_file_toserver ($fileurl,$savefile);
//  }
// }
// $profilephotos = urlencode($profilephotos);
// websima_sendmessage ($user_id,$profilephotos,$token);
    function websima_sendphoto($token, $chat_id, $caption, $photo)
    {
        $fields = array(
            'chat_id' => $chat_id,
            // make sure you do NOT forget @ sign
//          'photo' =>
//           '@'            . $photo
//           . ';filename=' . $filename,
            'photo' => $photo,
            'caption' => $caption,
            'disable_notification' => true
        );
//  foreach ($fields as $field) {
// send_group_message($chat_id,$token,$field);
//  }
        $url = 'https://api.telegram.org/bot' . $token . '/sendPhoto';

        //  open connection
        $ch = curl_init();
        //  set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        //  number of POST vars
        curl_setopt($ch, CURLOPT_POST, count($fields));
        //  POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //  To display result of curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  execute post
        $result = curl_exec($ch);

        //  close connection
        curl_close($ch);
//  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id.'&text='.$result;
//      file_get_contents($url);
    }

    function websima_sendphoto_sendfromhostserver($token, $chat_id, $caption, $photo, $filename)
    {
        $fields = array(
            'chat_id' => $chat_id,
            // make sure you do NOT forget @ sign
            'photo' =>
                '@' . $photo
                . ';filename=' . $filename,
            //'photo' => 'AgADBAADrqcxG6RuwwZDFBahwsgdvx2lRBkABN8gsAvLf44i4NgBAAEC',
            'caption' => $caption,
            'disable_notification' => true
        );
//  foreach ($fields as $field) {
// send_group_message($chat_id,$token,$field);
//  }
        $url = 'https://api.telegram.org/bot' . $token . '/sendPhoto';

        //  open connection
        $ch = curl_init();
        //  set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        //  number of POST vars
        curl_setopt($ch, CURLOPT_POST, count($fields));
        //  POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //  To display result of curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  execute post
        $result = curl_exec($ch);

        //  close connection
        curl_close($ch);
//  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$chat_id.'&text='.$result;
//      file_get_contents($url);
    }

// $audio = getcwd().'/sample.mp3';
// $duration = '108';
// $performer = 'pallete';
// $title = 'websima';
// websima_sendaudio($token,$user_id, $audio,$duration,$performer,$title);
    function websima_sendaudio($token, $user_id, $audio, $duration, $performer, $title)
    {
        $filename = 'sample';
        $fields = array(
            'chat_id' => $user_id,
            // make sure you do NOT forget @ sign
            'audio' =>
                '@' . $audio
                . ';filename=' . $filename,
            // 'photo' => 'AgADBAADrqcxG6RuwwZDFBahwsgdvx2lRBkABN8gsAvLf44i4NgBAAEC',
            'duration' => $duration,
            'performer' => $performer,
            'title' => $title,
            'disable_notification' => false
        );

        $url = 'https://api.telegram.org/bot' . $token . '/sendAudio';
        //  open connection
        $ch = curl_init();
        //  set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        //  number of POST vars
        curl_setopt($ch, CURLOPT_POST, count($fields));
        //  POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //  To display result of curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  execute post
        $result = curl_exec($ch);

        //  close connection
        curl_close($ch);

//  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$user_id.'&text='.$result;
//  file_get_contents($url);
    }

    function websima_sendvideo($token, $user_id, $video, $duration, $width, $height, $caption)
    {
        $filename = 'sample';
        $fields = array(
            'chat_id' => $user_id,
            // make sure you do NOT forget @ sign
            'video' =>
                '@' . $video
                . ';filename=' . $filename,
            'duration' => $duration,
            'width' => $width,
            'height' => $height,
            'caption' => $caption,
            'disable_notification' => false
        );

        $url = 'https://api.telegram.org/bot' . $token . '/sendVideo';
        //  open connection
        $ch = curl_init();
        //  set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        //  number of POST vars
        curl_setopt($ch, CURLOPT_POST, count($fields));
        //  POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //  To display result of curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  execute post
        $result = curl_exec($ch);

        //  close connection
        curl_close($ch);

//  $url = 'https://api.telegram.org/bot'.$token.'/sendMessage?chat_id='.$user_id.'&text='.$result;
//  file_get_contents($url);
    }

//Send Text Message With Inline Keyboard
    function websima_inlinekeyboardmessage($user_id, $message, $token, $keyboard)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage';
        $replyMarkup = array(
            'inline_keyboard' => $keyboard
        );
        $encodedMarkup = json_encode($replyMarkup);
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $user_id . '&text=' . $message . '&reply_markup=' . $encodedMarkup;
        $update = file_get_contents($url);
    }

//Send Text Message
    function websima_sendmessage($user_id, $message, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $user_id . '&text=' . $message;
        $update = file_get_contents($url);
    }

//Get File
    function websima_getfile($file_id, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/getFile?file_id=' . $file_id;
        $updates = file_get_contents($url);
        $update = urldecode($updates);
        $update = json_decode($update);
        $result = $update->result;
        $filepath = $result->file_path;
        return $filepath;
    }

//Download File
    function download_file_toserver($fileurl, $name)
    {
        file_put_contents($name, fopen($fileurl, 'r'));
    }

//sendChatAction
    function sendChatAction($user_id, $chataction, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/sendChatAction?chat_id=' . $user_id . '&action=' . $chataction;
        $update = file_get_contents($url);
    }

//getUserProfilePhotos
    function getUserProfilePhotos($user_id, $offset, $limit, $token)
    {
        $url = 'https://api.telegram.org/bot' . $token . '/getUserProfilePhotos?user_id=' . $user_id . '&offset=' . $offset . '&limit=' . $limit;
        $update = file_get_contents($url);
        return $update;
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

// $fullstring = 'this is my [tag]dog[/tag]';
// $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
    function workWithUserProfile($chat_id, $user_id, $token)
    {
        //تعیین پارامترهای دریافت عکس پروفایل
        $offset = 0;
        $limit = 5;
//دریافت تصویر پروفایل کاربر
        $profilephotos = getUserProfilePhotos($user_id, $offset, $limit, $token);
// شناسایی پیام دریافتی و پیدا کردن تصاویر در آن
        $profilephotos = json_decode($profilephotos);
        $result = $profilephotos->result;
        $photos = $result->photos;
// شرط مناسب برای چک کردن اینکه کاربر عکس داشته یا نه
        if (is_array($photos)) {
//ساخت دایرکتورهای مناسب برای هر کاربر

//  if (mkdir('telegram/'.$user_id, 0777, true)) {
// //     send_group_message($chat_id,$token,'Failed to create folders...');
//      mkdir('telegram/'.$user_id);
// }

            //mkdir ('telegram/'.$user_id);
            mkdir('telegram/' . $user_id . '/photos');
// ایجاد حلقه برای هر شناسایی هر تصویر
            foreach ($photos as $photo) {
//دریافت تعداد سایزهای موجود از هر عکس      
                $count = count($photo) - 1;
//دریافت آی دی عکسی که بهترین کیفیت را دارد
                $file_id = $photo[$count]->file_id;
//دریافت آدرس فایل در سرور تلگرام
                $getfile = websima_getfile($file_id, $token);
// ساخت آدرس قابل دسترسی براساس نام فایل ساخته شده      
                $fileurl = 'https://api.telegram.org/file/bot' . $token . '/' . $getfile;
// تعیین مسیر صحیح برای ذخیره فایل
                $savefile = 'telegram/' . $user_id . '/' . $file_id;
// ذخیره تصویر از سرور تلگرام در فولدر بندی مورد نظر
//      download_file_toserver ($fileurl,$savefile);
//      send_group_message($chat_id,$token," getcwd getfile :". '/telegram/'. $user_id.'/'.$getfile );
//      send_group_message($chat_id,$token,str_replace('photos/','',$getfile));
//      websima_sendphoto($token,$user_id, $caption, $fileurl,$filename);
                //send photos
//       $url = 'https://api.telegram.org/bot'.$token.'/sendPhoto';
// $botToken = "yourbottoken";
// $chat_id = "@yourchannel";
// $message = "your message";
// $bot_url    = "https://api.telegram.org/bot$token/";
// $url = $bot_url."sendPhoto?chat_id=".$chat_id."&photo=".$file_id;
// file_get_contents($url);
                $caption = "چه عکس قشنگی";

//      websima_sendphoto($token,$chat_id, $caption, $photo,$filename);
                //  websima_sendphoto($token,$user_id, $caption,  getcwd().'/telegram/'. $user_id.'/'.$getfile,str_replace('photos/','',$getfile));
//ttest($token,$user_id, $caption,$file_id,"");
                websima_sendphoto($token, $chat_id, $caption, $file_id, '');
            }
        }
    }

    function insert2db($userid, $tele_username, $grouplink, $groupid, $groupusername, $grouptitle, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO antilink(userid,username, grouplink,groupid,groupusername,grouptitle) VALUES ('" . $userid . "', '" . $tele_username . "', '" . $grouplink . "', '" . $groupid . "', '" . $groupusername . "', '" . $grouptitle . "')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function insert2settingdb($groupid, $noatsign, $nolink, $noforward, $isvalid, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO setting(groupid ,noatsign , nolink ,noforward,isvalid) VALUES ('" . $groupid . "', '" . $noatsign . "', '" . $nolink . "', '" . $noforward . "', '" . $isvalid . "')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function insert2usersdb($groupid, $userid, $tele_username, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO users(groupid ,userid , username) VALUES ('" . $groupid . "', '" . $userid . "', '" . $tele_username . "')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }

    function getInfoUsersDb($servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT groupid,userid , username  FROM users GROUP BY(userid) ";
        $executingFetchQuery = $conn->query($sql);
        $groupid = array();//to store results
        $userid = array();
        $usernames = array();
        if ($executingFetchQuery) {
            while ($arr = $executingFetchQuery->fetch_assoc()) {
                $groupid[] = $arr['groupid'];//storing values into an array
                $grouplinks[] = $arr['userid'];
                $usernames[] = $arr['username'];
            }
        }
        $conn->close();
        return array($groupid, $userid, $usernames);
    }

    function getInfoSettingDb($chat_id, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT groupid,noatsign , nolink ,noforward,isvalid FROM setting WHERE groupid = '" . $chat_id . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
            return array($row["groupid"], $row["noatsign"], $row["nolink"], $row["noforward"], $row["isvalid"]);

        } else {
            echo "0 results";
        }
        $conn->close();
    }

    function checkPrivilegeDb($chat_id, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT groupid,issetprivilege FROM privilege WHERE groupid = '" . $chat_id . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
            return array($row["groupid"], $row["issetprivilege"]);

        } else {
            echo "0 results";
        }
        $conn->close();
    }

    function insertPrivilegDb($groupid, $issetprivilege, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO privilege(groupid ,issetprivilege) VALUES ('" . $groupid . "', '" . $issetprivilege . "')";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
        $conn->close();
    }

    function UpdatePrivilegDb($groupid, $issetprivilege, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "UPDATE privilege SET issetprivilege='" . $issetprivilege . "' WHERE groupid='" . $groupid . "'";
        if ($conn->query($sql) === TRUE) {
            //echo "New record created successfully";
            return true;
        } else {
            //echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
        $conn->close();
    }

    function selectfromdb($servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, userid,username, grouplink,groupid,groupusername,grouptitle FROM antilink  ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
            return array($row["userid"], $row["username"], $row["grouplink"], $row["groupid"], $row["groupusername"], $row["grouptitle"]);

        } else {
            echo "0 results";
        }
        $conn->close();
    }

    function groupsOfBot($servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, groupid,grouplink FROM antilink";
        $executingFetchQuery = $conn->query($sql);
        $resultArr = array();//to store results
        $grouplinks = array();
        $ids = array();
        if ($executingFetchQuery) {
            while ($arr = $executingFetchQuery->fetch_assoc()) {
                $resultArr[] = $arr['groupid'];//storing values into an array
                $grouplinks[] = $arr['grouplink'];
                $ids[] = $arr['id'];
            }
        }
        $conn->close();
        return array($resultArr, $grouplinks, $ids);
    }

    function getChatFromDb($chat_id, $servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT id, userid,username, grouplink,groupid,groupusername,grouptitle FROM antilink WHERE groupid = '" . $chat_id . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
            return array($row["userid"], $row["username"], $row["grouplink"], $row["groupid"], $row["groupusername"], $row["grouptitle"]);

        } else {
            echo "0 results";
        }
        $conn->close();
    }

    function alterColumn($servername, $username, $password, $dbname)
    {
// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "ALTER TABLE setting ADD isvalid VARCHAR( 1 ) after noforward";
        if ($conn->query($sql)) {
            // output data of each row
            echo "it worked";

        } else {
            echo "something wrong with ALTER";
        }
        $conn->close();
    }

    function fileName($file)
    {
        $path_parts = pathinfo($file);
        if (isset($path_parts['filename'])) {
            return $path_parts['filename'];
        } else {
            return false;
        }
    }

    function fileExt($file)
    {

        $path_parts = pathinfo($file);
        if (isset($path_parts['extension'])) {
            return $path_parts['extension'];
        } else {
            return false;
        }
    }

    function fileDir($file)
    {
        $path_parts = pathinfo($file);
        if (isset($path_parts['dirname'])) {
            return $path_parts['dirname'];
        } else {
            return false;
        }
    }


//CREATE TABLE tblchatusers (
//    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
//    user_id INT ,
//	username VARCHAR(33) NULL,
//    isenable  TINYINT(1) NULL,
//    isstart TINYINT(1) NULL,
//   	ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//);

// photoid VARCHAR(128) NULL,