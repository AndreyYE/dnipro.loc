<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/app/entity/User.php");
include($_SERVER['DOCUMENT_ROOT'] . "/app/entity/Contacts.php");
include($_SERVER['DOCUMENT_ROOT'] . "/app/entity/Favorites.php");
include($_SERVER['DOCUMENT_ROOT'] . "/environment.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_SERVER['QUERY_STRING']=="register"){
        include 'app/views/register.php';
    }
    elseif ($_SERVER['QUERY_STRING']=="login"){
        include 'app/views/login.php';
    }
    elseif ($_SERVER['QUERY_STRING']=="contacts"){
        include 'app/views/contacts.php';
    }
}elseif ($_SERVER["REQUEST_METHOD"]=="GET"){
    if($_SERVER['QUERY_STRING']=="login" || $_SERVER['QUERY_STRING']=="register" || $_SERVER['QUERY_STRING']=="contacts" || $_SERVER['QUERY_STRING']=="favorites"){
        include 'app/views/app.php';

    }
else{
    header("Location: ".strtolower(explode('/',$_SERVER['SERVER_PROTOCOL'])[0])."://".$_SERVER['HTTP_HOST']."/contacts");
    exit();
}
}

