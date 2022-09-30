<?php

require_once 'apiRequest.php';

function request($url)
{
    $curl = new TwitterApiRequests();
    $curl->setApiEndpoint($url);
    $request = json_decode($curl->sendRequest(), true);
    //guardarSalida($request);
    return $request;
}


/**
 * Devuelve el ID del usuario
 */
function getUserID($user)
{
    $url = "https://api.twitter.com/2/users/by?usernames={$user}";
    $userData = request($url);
    $userID = $userData["data"][0]["id"];
    $userName = $userData["data"][0]["name"];

    echo "User ID: {$userID}\n";
    echo "User Name: {$userName}\n";

    return $userData;
}


/**
 * Devuelve los tweets de los últimos 7 días del usuario
 */
function getUserTweets($user)
{
    $url = "https://api.twitter.com/2/tweets/search/recent?query=from:{$user}";
    $userData = request($url);
    return $userData;
}

/**
 * Postea un tweet
 */
function postTweet($text)
{
    $url = "https://api.twitter.com/2/tweets?text={$text}";
    $userData = request($url);
    return $userData;
}

function guardarSalida($salida)
{
    //$fichero = fopen("salida_api.json", "w");
    $fichero = fopen("debug.log", "a");

    fwrite($fichero, date("Y-m-d H:i:s") . ": Inicio petición API Twitter");
    if (count($salida) > 0) {
        for ($i = 0; $i < count($salida); $i++) {
            fwrite($fichero, $salida[$i]);
        }
    }

    fwrite($fichero, date("Y-m-d H:i:s") . ": Fin petición API Twitter");
    fclose($fichero);
}

getUserID("mangelgl2");
//getUserTweets("mangelgl2");
//postTweet("Hello World! Tweet send from PHP script");
