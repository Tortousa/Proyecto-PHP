<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

// Página de inicio pública — visible sin necesidad de estar registrado.
// Muestra todos los coches publicados en la plataforma con un buscador sencillo.
class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Solo mostramos coches con fecha de publicación — los borradores no aparecen
        $query = Car::whereNotNull('published_at')
            ->with(['maker', 'model', 'primaryImage', 'city', 'fuelType']);

        // Filtros opcionales desde la barra de búsqueda del hero
        if ($request->filled('maker')) {
            $query->byMaker($request->maker);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        if ($request->filled('fuel_type')) {
            $query->ofFuelType($request->fuel_type);
        }

        // Paginamos a 12 para que la grid 4 columnas quede equilibrada
        $cars = $query->latest()->paginate(12);

        return view('home', compact('cars'));
    }
}
