<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Panel principal del usuario autenticado.
// Muestra los coches publicados de OTROS usuarios — el objetivo es que el usuario
// descubra anuncios, no que vea los suyos (para eso está MyCars).
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Partimos de los coches publicados que no son del usuario actual
        $query = Car::whereNotNull('published_at')
            ->where('user_id', '!=', Auth::id());

        // Filtros opcionales: el usuario puede acotar la búsqueda desde el formulario
        if ($request->filled('maker')) {
            $query->byMaker($request->maker);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceBetween($request->min_price, $request->max_price);
        }

        if ($request->filled('fuel_type')) {
            $query->ofFuelType($request->fuel_type);
        }

        // Cargamos las relaciones necesarias para la vista de una sola vez (eager loading)
        $featuredCars = $query
            ->with(['maker', 'model', 'primaryImage', 'city'])
            ->latest()
            ->paginate(6);

        return view('dashboard', compact('featuredCars'));
    }
}
