<?php

namespace App\Http\Controllers;

use App\Http\Services\ResponseFormatterService;
use App\Http\Services\CityListService;

class CityListController extends Controller
{
    private $cityListService;
    private $responseFormatterService;

    public function __construct(
        CityListService $cityListService,
        ResponseFormatterService $responseFormatterService
    ) {
        $this->cityListService = $cityListService;
        $this->responseFormatterService = $responseFormatterService;
    }

    public function getCityList() {
        return $this->responseFormatterService->success($this->cityListService->getAll());
    }
}
