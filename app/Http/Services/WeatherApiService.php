<?php
namespace App\Http\Services;

use App\Http\Services\CurlService;

use Config;
use Exception;

class WeatherApiService
{
    private $curlService;
    private $countryCode;
    private $apiKey;
    private $apiUrl;

    public function __construct(CurlService $curlService)
    {
        $this->curlService = $curlService;
        $this->countryCode = Config::get('custom.api.countryCode');
        $this->apiKey = Config::get('custom.api.weatherApiKey');
        $this->apiUrl = Config::get('custom.api.weatherApiUrl');
    }

    public function get($city, $cnt = null) {
        $queries = ['q' => $city.','.$this->countryCode, 'appid' => $this->apiKey];
        
        if($cnt!==null) {
            $queries['cnt'] = $cnt;
        }

        $url = $this->apiUrl . '?'. http_build_query($queries);
        $apiResult = $this->curlService->request(
            $url,
            [], 
            ['CUSTOPT_METHOD' => 'get']
        );
        $isApiSuccess = is_array($apiResult) && isset($apiResult['cod']) && $apiResult['cod'] == '200';

        if ($isApiSuccess) {
            return $apiResult;
        } else {
            throw new Exception('Failed weather API request', $apiResult);
        }
    }
}
