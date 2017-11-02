<?php

class WeatherService
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getWeatherState()
    {
        $state = $this->my_mb_ucfirst($this->data->weather[0]->description);

        return $state;
    }

    public function getTemperatureInCelsius()
    {
        $tempInC = $this->data->main->temp - 273;

        return $tempInC;
    }

    public function getIcon()
    {
        $icon = $this->data->weather[0]->icon;

        return $icon;
    }

    public function getHumidity()
    {
        $humidity = $this->data->main->humidity;

        return $humidity;
    }

    public function getWindSpeed()
    {
        $wind = $this->data->wind->speed;

        return $wind;
    }

    public function getCloudly()
    {
        $cloudly = $this->data->clouds->all;

        return $cloudly;
    }

    private function my_mb_ucfirst($str) {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc.mb_substr($str, 1);
    }

}