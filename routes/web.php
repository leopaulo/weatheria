<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/{path?}', 'index')->where('path', '^(?!api).*$');