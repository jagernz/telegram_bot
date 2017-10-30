<?php

include('vendor/autoload.php');
include('TelegramBot.php');

$telegramApi = new TelegramBot();

while (true) {
    sleep(2);
    $updates = $telegramApi->getUpdates();

    foreach ($updates as $update) {
        $telegramApi->sendMessage('Погода скоро начнет работать, не ссы, Карл!', $update->message->chat->id);
    }
}

