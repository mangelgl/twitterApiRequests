<?php

require_once 'apiRequest.php';

function request($url, $metodo = "GET")
{
    $curl = new TwitterApiRequest();
    $curl->setArrayOptions($url, $metodo);
    return $curl->sendRequest();
}


function getUserID($user)
{
    $url = "https://api.twitter.com/2/users/by?usernames={$user}";
    $userData = request($url);
    $result = json_decode($userData, JSON_PRETTY_PRINT);
    $userID = $result["data"][0]["id"];

    return $userID;
}

function getUserTweets($user)
{
    //$userID = getUserID($user);
    $url = "https://api.twitter.com/2/tweets/search/recent?query=from:{$user}";
    $userData = request($url);
    guardarSalida($userData);
    return $userData;
}

function postTweet($text)
{
    $url = "https://api.twitter.com/2/tweets?text={$text}";
    $userData = request($url, "POST");
    guardarSalida($userData);
    return $userData;
}

function guardarSalida($salida)
{
    $fichero = fopen("salida_api.json", "w");
    fwrite($fichero, $salida);
    fclose($fichero);
}

getUserTweets("mangelgl2");
//postTweet("Hello World! Tweet send from PHP script");
