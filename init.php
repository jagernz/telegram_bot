<?php

include('vendor/autoload.php');
include('TelegramBot.php');
include('Weather.php');

$telegramApi = new TelegramBot();
$weatherApi = new Weather();

//while (true) {
//    sleep(3);

    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {

//        print_r($update);
//        echo '<hr>';

        switch ($update->message->text) {
            case '/start':
                $telegramApi->sendMessage('Здравствуй, Карл! В каком городе погода нужна?',$update->message->chat->id);
                break;
            default:
                $result = $weatherApi->getWeather($update->message->text);
                if ($result) {

                    print_r($result);

                    $telegramApi->sendMessage('Состояние - '.$result->weather[0]->description,$update->message->chat->id);

                    $telegramApi->sendPhoto($update->message->chat->id,'http://openweathermap.org/img/w/' . $result->weather[0]->icon . '.png');

//                    $telegramApi->sendPhoto($update->message->chat->id,'https://jagerbots.pp.ua/images.jpg');

//                    $telegramApi->sendMessage(json_encode($result), $update->message->chat->id);

                }

//                $telegramApi->sendMessage('В каком городе погода нужна, Карл!',$update->message->chat->id);
        }
    }

//            $result = $weatherApi->getWeather($update->message->text);
//            $telegramApi->sendMessage(json_decode($result),$update->message->chat_id);

//}

