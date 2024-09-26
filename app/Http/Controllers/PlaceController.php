<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetNearbyPlaceRequest;
use App\Http\Services\PlaceApiService;
use App\Http\Services\CacheService;
use App\Http\Services\ResponseFormatterService;
use Config;

class PlaceController extends Controller
{
    private $placeApiService;
    private $cacheService;
    private $responseFormatterService;

    public function __construct(
        PlaceApiService $placeApiService, 
        CacheService $cacheService,
        ResponseFormatterService $responseFormatterService
    ) {
        $this->placeApiService = $placeApiService;
        $this->cacheService = $cacheService;
        $this->responseFormatterService = $responseFormatterService;
    }

    public function getNearby(GetNearbyPlaceRequest $request) {
        $data =  $this->cacheService->get(
                    $request->city . 'nearby', 
                    function() use($request) { 
                        return $this->formatData($this->placeApiService->get($request->city));
                    },
                    Config::get('custom.api.nearbyPlaceCacheExpiration')
                );

        return $this->responseFormatterService->success($data);
    }

    private function formatData($data) {
        return array_map(function($item) {
            return [
                'name'=> $item["name"],
                'categories' => array_map(function($categoryItem) {
                    return $categoryItem['name'];
                },$item['categories']),
                'geocodes' => $item["geocodes"]["main"],
                'closedBucket' => $item["closed_bucket"],
                'address' => $item["location"]["formatted_address"]
            ];
        },$data['results']);
    }

}
