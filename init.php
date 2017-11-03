<?php

$request = file_get_contents('php://input');
$request = json_decode( $request, TRUE );

include('vendor/autoload.php');
include('TelegramBot.php');
include('Weather.php');
include('WeatherService.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('REQUEST_INFO');
$log->pushHandler(new StreamHandler('app.log', Logger::DEBUG));

// add records to the log
$log->addDebug($request);

//$telegramApi = new TelegramBot();
//$weatherApi = new Weather();

//var_dump($_REQUEST);
die();

//while (true) {
//
//    sleep(3);

    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {

        switch ($update->message->text) {

            case '/start':

                $telegramApi->sendMessage(
                    'Привет, '.$update->message->from->first_name.'! Пиши в каком городе нужна погода!',
                    $update->message->chat->id
                );
                break;

            case 'Прикольно!':

                $telegramApi->sendMessage(
                    'Спасибо, Карл! Это мой первенец.',
                    $update->message->chat->id
                );
                break;

            case 'Хуйня!':

                $telegramApi->sendMessage(
                    'Сам ты хуйня!',
                    $update->message->chat->id
                );
                break;

            default:

                $result = $weatherApi->getWeather($update->message->text);

                if ($result) {

                    $service = new WeatherService($result);

//                    print_r($result);
//                    echo '<hr>';

                    $telegramApi->sendMessage(
                        '###### Расчет ссаной погоды ######',
                        $update->message->chat->id
                    );

                    $telegramApi->sendPhoto(
                        $update->message->chat->id,
                        'http://openweathermap.org/img/w/' . $service->getIcon() . '.png'
                    );

//                    Вставляем сюда инфу от апи погоды

                    $telegramApi->sendMessage(
                        'Ссаная оценка местности .... '.$service->getWeatherState(),
                        $update->message->chat->id
                    );

                    $telegramApi->sendMessage(
                        'Оценка ссаной температуры .... '.$service->getTemperatureInCelsius().' цельс.',
                            $update->message->chat->id
                    );

                    $telegramApi->sendMessage(
                        'Оценка ссаного ветра .... '.$service->getWindSpeed().'м/с.',
                            $update->message->chat->id,
                        ['Прикольно!','Хуйня!']
                    );

                } else {

                    $telegramApi->sendMessage(
                        'Ты что ебешь меня, Карл?',
                            $update->message->chat->id
                    );
                }
        }

    }

//}

