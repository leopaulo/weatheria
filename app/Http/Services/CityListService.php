<?php

namespace App\Http\Services;

use App\Exceptions\RequestException;
use Config;
use Storage;

class CityListService
{
	public function getAll() {
       $cityArray = json_decode(Storage::get(Config::get('custom.reference.cityListJson')), true);  
       return array_map('strtolower',$cityArray);
    }
}
