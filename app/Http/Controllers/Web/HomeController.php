<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

// Página de inicio pública — visible sin necesidad de estar registrado.
// La búsqueda y el listado de coches los gestiona el componente Livewire CarSearch,
// por lo que el controlador solo se encarga de renderizar la vista.
class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
