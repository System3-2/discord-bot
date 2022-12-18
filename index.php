<?php

use Discord\Discord;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;

require_once('./vendor/autoload.php');
require_once('./key.php');

$key = getKey();


$discord = new Discord(['token' => $key]);
$discord->on('ready', function (Discord $discord) {
    echo "Bot is ready to receive messages";
    $discord->on('message', function ($message, $discord) {
        $content = $message->content;
        if (strpos($content, '!' === false)) return;
        echo $content;

        if ($content === '!joke') {
            // Get joke from API
            $client = new GuzzleHttp\Client();
            $response = $client->request('GET', 'https://api.chucknorris.io/jokes/random');
            $joke = json_decode($response->getBody());
            var_dump($joke);
            $joke = $joke->value;
            $message->reply($joke);
        }
    });
});
$discord->run();
