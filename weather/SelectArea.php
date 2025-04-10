<?php 
use GuzzleHttp\Client;
require __DIR__."/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();

class SelectArea{
    protected $area;
    protected $apiKey;

    public function __construct($area){
        $this->apiKey = $_ENV["WEATHER_KEY"];
        $this->area = $area;
    }

    public function showWeather(){
        $apiURL = "https://api.openweathermap.org/data/2.5/weather?q=".$this->area."&units=metric&appid={$this->apiKey}";
        $client = new Client();
        $response = $client->get($apiURL);

        $data = json_decode($response->getBody(), true);
        print_r($data);
    }
}

$weather = new SelectArea(readline("Where do you want to check the weather for: "));
$weather->showWeather();
?>