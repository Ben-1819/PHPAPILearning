<?php
//namespace Weather;
use GuzzleHttp\Client;
require __DIR__."/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

class Weather{
    public function getWeather(){
        $apiKey = $_ENV["WEATHER_KEY"];
        $client = new Client;

        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=Lisburn&units=metric&appid={$apiKey}";
        $response = $client->get($apiUrl);

        $data = json_decode($response->getBody(), true);
        print_r($data);
    }
}

$weather = new Weather;
$weather->getWeather();
?>