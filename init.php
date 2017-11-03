<?php

include('vendor/autoload.php');
include('TelegramBot.php');
include('Weather.php');
include('WeatherService.php');
include('Log.php');

    $chatId  = $request['message']['chat']['id'];
    $message = $request['message']['text'];
    $from = $request['message']['from']['first_name'];

    $telegramApi = new TelegramBot();
    $weatherApi = new Weather();


    switch ($message) {

        case '/start':

            $telegramApi->sendMessage(
                'Привет, '.$from.'! Пиши в каком городе нужна погода!',
                $chatId
            );
            break;

        case 'Прикольно!':

            $telegramApi->sendMessage(
                'Спасибо, Карл! Это мой первенец.',
                $chatId
            );
            break;

        case 'Хуйня!':

            $telegramApi->sendMessage(
                'Сам ты хуйня!',
                $chatId
            );
            break;

        default:

            $result = $weatherApi->getWeather($message);
            if ($result) {
                $service = new WeatherService($result);
                $telegramApi->sendMessage(
                    '###### Расчет ссаной погоды ######',
                    $chatId
                );
                $telegramApi->sendPhoto(
                    $chatId,
                    'http://openweathermap.org/img/w/' . $service->getIcon() . '.png'
                );
                $telegramApi->sendMessage(
                    'Ссаная оценка местности .... '.$service->getWeatherState(),
                    $chatId
                );
                $telegramApi->sendMessage(
                    'Оценка ссаной температуры .... '.$service->getTemperatureInCelsius().' цельс.',
                    $chatId
                );
                $telegramApi->sendMessage(
                    'Оценка ссаного ветра .... '.$service->getWindSpeed().'м/с.',
                    $chatId,
                    ['Прикольно!','Хуйня!']
                );
            } else {
                $telegramApi->sendMessage(
                    'Ты что ебешь меня, Карл?',
                    $chatId
                );
            }
    }