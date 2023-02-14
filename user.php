<?php

function setPage($chat_id, $page){
    file_put_contents('users/'.$chat_id. 'page.txt', $page);
}

function getPage($chat_id){
    return file_get_contents('users/'.$chat_id. 'page.txt');
}