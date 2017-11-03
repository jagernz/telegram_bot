<?php

use GuzzleHttp\Client;

class TelegramBot
{
    protected $token = '439390884:AAF36YOeLq5Hc8nJfg9W1iHw8HbVNbY7EKE';
    protected $updateId;

    public function query($method, $params = [])
    {
        $url = "https://api.telegram.org/bot";
        $url .= $this->token;
        $url .= "/" . $method;

        if (!empty($params)) {
            $url .= "?". http_build_query($params);
        }

        $client = new Client([
            'base_uri' => $url
        ]);

        $result = $client->request('GET');

        return json_decode($result->getBody());
    }

    public function getUpdates()
    {
        $response = $this->query('getUpdates', [
            'offset' => $this->updateId + 1
        ]);

        if (!empty($response->result)) {
            $this->updateId = $response->result[count($response->result) - 1 ]->update_id;
        }

        return $response->result;
    }

    public function getWebhookinfo()
    {
        $response = $this->query('getWebhookinfo');

//        return $response->result;
        return $response;
    }

    public function sendMessage($text, $chat_id, $reply = null)
    {
        if ($reply == null) {

            $response = $this->query('sendMessage', [
                'text' => $text,
                'chat_id' => $chat_id,
            ]);

        } else {

            $response = $this->query('sendMessage', [
                'text' => $text,
                'chat_id' => $chat_id,
                'reply_markup' => $this->replyKeyboardMarkup($reply)
            ]);

        }

        return $response;
    }

    public function sendPhoto($chat_id, $photo)
    {
        $response = $this->query('sendPhoto', [
            'chat_id' => $chat_id,
            'photo' => $photo
        ]);

        return $response;
    }

    public function replyKeyboardMarkup($keyboard, $resize_keyboard = true, $one_time_keyboard = true)
    {
        return json_encode([
            'keyboard' => [$keyboard],
            'resize_keyboard' => $resize_keyboard,
            'one_time_keyboard' => $one_time_keyboard
        ]);
    }
}