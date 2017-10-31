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
        $responce = $this->query('getUpdates', [
            'offset' => $this->updateId + 1
        ]);

        if (!empty($responce->result)) {
            $this->updateId = $responce->result[count($responce->result) - 1 ]->update_id;
        }

        return $responce->result;
    }

    public function sendMessage($text, $chat_id)
    {
        $response = $this->query('sendMessage', [
            'text' => $text,
            'chat_id' => $chat_id
        ]);

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
}