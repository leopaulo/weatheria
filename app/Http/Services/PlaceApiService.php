<?php
namespace App\Http\Services;

use App\Http\Services\CurlService;

use Config;

class PlaceApiService
{
    private $curlService;
    private $countryCode;
    private $apiKey;
    private $apiUrl;

    public function __construct(CurlService $curlService)
    {
        $this->curlService = $curlService;
        $this->countryCode = Config::get('custom.api.countryCode');
        $this->apiKey = Config::get('custom.api.placeApiKey');
        $this->apiUrl = Config::get('custom.api.placeApiUrl');
    }

    public function get($city) {
        $queries = ['near' => $city.','.$this->countryCode];

        $url = $this->apiUrl . '?'. http_build_query($queries);
        $apiResult = $this->curlService->request(
            $url,
            [], 
            ['CUSTOPT_METHOD' => 'get', 'CURLOPT_HTTPHEADER' => [
                "Authorization: ". $this->apiKey,
                "accept: application/json" 
            ]]
        );

        $isApiSuccess = is_array($apiResult) && isset($apiResult['results']) && $apiResult['results'] > 0;
        
        if($isApiSuccess) {
            return $apiResult;
        } else {
            throw new Exception('Failed place API request', $apiResult);
        }
    }
}
