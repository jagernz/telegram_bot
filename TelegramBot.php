<?php

use GuzzleHttp\Client;

class TelegramBot
{
    protected $token = '439390884:AAF36YOeLq5Hc8nJfg9W1iHw8HbVNbY7EKE';

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
        $responce = $this->query('getUpdates');

        return $responce->result;
    }

    public function sendMessage()
    {

    }
}