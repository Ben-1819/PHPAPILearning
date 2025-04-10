<?php 
use GuzzleHttp\Client;
require __DIR__."/../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();

class SelectInformation{
    protected $area;
    protected $apiKey;
    protected $data;
    public function __construct($area){
        $this->area = $area;
        $this->apiKey = $_ENV["WEATHER_KEY"];
        $this->data = [];
    }

    public function set_data($data){
        $this->data = $data;
        return $this->data;
    }
    public function getResponse(){
        $client = new Client;
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=".$this->area."&units=metric&appid={$this->apiKey}";

        $response = $client->get($apiUrl);
        $data = json_decode($response->getBody(), true);
        $this->set_data($data);
        $this->choice();
    }
    public function choice(){
        $level = readline("How detailed do you want the report to be? (Very, Average, Little) ");
        switch(strtolower($level)){
            case "very":
                $this->veryDetail();
                break;
            case "average":
                $this->averageDetail();
                break;
            case "little":
                $this->littleDetail();
                break;
            default:
                print "Only enter very, little or average.\n";
                $this->choice();
        }
    }

    public function veryDetail(){
        print "Main weather: ".$this->data['weather'][0]['main']."\nDescription: ".$this->data['weather'][0]['description']."\nID: ".$this->data['weather'][0]['id']."\n";
        print "Temperature Information:\n\tTemperature: ".$this->data['main']['temp']."\n\tFeels Like: ".$this->data['main']['feels_like'].
        "\n\tMax temp: ".$this->data['main']['temp_max']."\n\tMin temp: ".$this->data['main']['temp_min']."\n\tPressure: ".$this->data['main']['pressure'].
        "\n\tHumidity: ".$this->data['main']['humidity']."\n";
        print "Visibility: ".$this->data['visibility']."m\n";
        print "Wind: \n\tWindspeed: ".$this->data['wind']['speed']."\n\tDegrees: ".$this->data['wind']['deg']."\n";
        print "Cloud coverage: ".$this->data['clouds']['all']."%\n";
    }

    public function averageDetail(){
        print "Main weather: ".$this->data['weather'][0]['main']."\nDescription: ".$this->data['weather'][0]['description']."\nID: ".$this->data['weather'][0]['id']."\n";
        print "Temperature Information:\n\tTemperature: ".$this->data['main']['temp']."\n\tFeels Like: ".$this->data['main']['feels_like'].
        "\n\tMax temp: ".$this->data['main']['temp_max']."\n\tMin temp: ".$this->data['main']['temp_min']."\n";
        print "Cloud coverage: ".$this->data['clouds']['all']."%\n";
    }

    public function littleDetail(){
        print "Main weather: ".$this->data['weather'][0]['main']."\nDescription: ".$this->data['weather'][0]['description']."\n";
        print "Temperature Information:\n\tTemperature: ".$this->data['main']['temp']."\n\tFeels Like: ".$this->data['main']['feels_like'].
        "\n";
    }
}

$weather = new SelectInformation(readline("Enter the area you want to get the weather for: "));
$weather->getResponse();
?>