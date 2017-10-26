<?php

include('vendor/autoload.php');
include('TelegramBot.php');

$telegramApi = new TelegramBot();
$updates = $telegramApi->getUpdates();

print_r($updates);