<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GetWeatherRequest;
use App\Http\Services\WeatherApiService;
use App\Http\Services\CacheService;
use App\Http\Services\ResponseFormatterService;
use DateTime;
use DateTimeZone;
use DateInterval;
use Config;

class WeatherController extends Controller
{
    private $weatherApiService;
    private $cacheService;
    private $responseFormatterService;

    public function __construct(
        WeatherApiService $weatherApiService, 
        CacheService $cacheService,
        ResponseFormatterService $responseFormatterService
    ) {
        $this->weatherApiService = $weatherApiService;
        $this->cacheService = $cacheService;
        $this->responseFormatterService = $responseFormatterService;
    }

    public function getWeather(GetWeatherRequest $request) {
        $data =  $this->cacheService->get(
                    $request->city . 'weather', 
                    function() use($request) { 
                        return $this->weatherApiService->get($request->city);
                    },
                    $this->getTodayRemainingSeconds()
                );
        return $this->responseFormatterService->success($this->formatWeatherData($data));
    }

    private function getTodayRemainingSeconds() {
        return mktime(24,0,0) - time();
    }

    private function formatWeatherData($data) {
        $forecast = [];
        $today = new DateTime();
        $today->sub(new DateInterval('PT3H'));
        $today = $today->format('Y-m-d');

        foreach ($data['list'] as $listItem) {
            $timeStamp = new DateTime($listItem['dt_txt'], new DateTimeZone('UTC'));
            $timeStamp->setTimezone(new DateTimeZone(Config::get('app.timezone')));
            $timeStampDate = $timeStamp->format('Y-m-d');

            if($timeStamp >= $today) {
                $isToday = $today == $timeStampDate;
                $time = $timeStamp->format('h:i A');

                if(!isset($forecast[$timeStampDate])) {
                    $forecast[$timeStampDate] = [
                        'date' => $timeStamp->format('M d'), 
                        'dateShortText'=> $isToday ? 'Today' : $timeStamp->format('D'), 
                        'list'=> []
                    ];

                    if($isToday) {
                        $time = date('h:i A');
                    }
                }
    
                array_push(
                    $forecast[$timeStampDate]['list'],
                    [
                        'time' => $time,
                        'temp' =>$listItem['main']['temp'],
                        'tempMax' =>$listItem['main']['temp_max'],
                        'tempMin' =>$listItem['main']['temp_min'],
                        'icon' =>$listItem['weather'][0]['icon'],
                        'description' =>$listItem['weather'][0]['description']
                    ]
                );
            }
        }

        return array_values($forecast);
    }
}
