<?php

function setPage($chat_id, $page){
    file_put_contents('users/'.$chat_id. 'page.txt', $page);
}

function getPage($chat_id){
    return file_get_contents('users/'.$chat_id. 'page.txt');
}

function setMassa($chat_id, $page){
    file_put_contents('users/'.$chat_id. 'massa.txt', $page);
}

function getMassa($chat_id){
    return file_get_contents('users/'.$chat_id. 'massa.txt');
}

function setPhone($chat_id, $page){
    file_put_contents('users/'.$chat_id. 'phone.txt', $page);
}

function getPhone($chat_id){
    return file_get_contents('users/'.$chat_id. 'phone.txt');
}