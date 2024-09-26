<?php

namespace App\Http\Services;

use Cache;

class CacheService
{
	public function get($key, $newDataFetchFunction, $expiration) {
        $key=strtolower($key);
        $cacheData = Cache::get($key);

		if(empty($cacheData)) {
			$newData = $newDataFetchFunction();
			Cache::put($key, $newData, $expiration);
			return $newData;
		} else {
			return $cacheData;
		}
    }
}
