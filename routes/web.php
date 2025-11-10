<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $person = [
        "name" => "Daniel",
        "email" => "danielltortosa@gmail.com",
    ];
    dump($person);
    return view('welcome');
});
