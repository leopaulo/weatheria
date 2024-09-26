<?php

return [
    'weatherApiUrl' => env('API_OWM_URL', 'api.openweathermap.org/data/2.5/forecast'),
    'weatherApiKey' => env('API_OWM_KEY'),
    'countryCode' => env('API_COUNTRY_CODE','JP'),
    'nearbyPlaceCacheExpiration' => env('API_FS_CACHE_EXPIRATION',432000),
    'placeApiUrl' => env('API_FS_URL', 'https://api.foursquare.com/v3/places/search'),
    'placeApiKey' => env('API_FS_KEY'),
];
