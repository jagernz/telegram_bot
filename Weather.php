<?php

class Weather
{
    protected $token = 'b2aaafbd49546f1316de1beee71f8300';

    public function getWeather($cityName)
    {
        $url = 'api.openweathermap.org/data/2.5/weather';

        $params = [];
        $params['q'] = $cityName;
        $params['appid'] = $this->token;

        $url .='?q='.$params['q'].'&appid='.$params['appid'].'&lang=ru';

        $client = new \GuzzleHttp\Client([
            'base_uri' => $url
        ]);

        try {
            $result = $client->request('GET');
        } catch (Exception $e) {
            return false;
        }

        return json_decode($result->getBody());
    }
}




















