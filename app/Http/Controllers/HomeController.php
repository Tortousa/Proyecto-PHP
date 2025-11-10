<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        //Selecciona todos los coches
        $cars = Car::get();

        return 'Index';
    }
}
