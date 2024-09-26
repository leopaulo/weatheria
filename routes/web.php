<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CityListController;

Route::post('get-weather', [WeatherController::class, 'getWeather']);
Route::post('get-nearby-place', [PlaceController::class, 'getNearby']);
Route::post('get-city-list', [CityListController::class, 'getCityList']);

Route::view('/{path?}', 'index')->where('path', '^(?!api).*$');