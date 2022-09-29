<?php

require_once 'apiRequest.php';
/* 
$curl = new TwitterApiRequest();
$url = "https://api.twitter.com/2/users/by?usernames={$user}";
$metodo = "GET";
$curl->setArrayOptions($url, $metodo);
$salida = $curl->request();

$fichero = fopen("salida_api.json", "w");
fwrite($fichero, $salida);
fclose($fichero);
 */
function request($url, $metodo = "GET")
{
    $curl = new TwitterApiRequest();
    $curl->setArrayOptions($url, $metodo);
    return $curl->request();
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
    $url = "https://api.twitter.com/2/tweets/search/recent?query={$user}";
    $userData = request($url);
    guardarSalida($userData);
    return $userData;
}

function guardarSalida($salida)
{
    $fichero = fopen("salida_api.json", "w");
    fwrite($fichero, $salida);
    fclose($fichero);
}

echo getUserTweets("mangelgl2") . "\n";
