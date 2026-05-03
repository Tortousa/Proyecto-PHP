<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Services\PdfService;
use Illuminate\Http\Request;

// Controlador encargado de generar y descargar los PDFs de la aplicación.
// Delega toda la lógica de generación al PdfService — aquí solo preparamos los datos.
class PdfController extends Controller
{
    public function __construct(private PdfService $pdfService) {}

    // PDF simple: ficha de un coche concreto con todos sus datos.
    // Cualquier usuario puede descargarla desde el detalle del anuncio.
    public function carDetail(Car $car)
    {
        $car->load(['maker', 'model', 'carType', 'fuelType', 'city', 'owner']);

        $nombre = "{$car->maker->name}_{$car->model->name}_{$car->year}.pdf";

        return $this->pdfService->download('pdfs.car-detail', compact('car'), $nombre);
    }

    // PDF complejo: informe general de todos los anuncios publicados.
    // Solo accesible para administradores — incluye estadísticas y listado completo.
    public function carsReport(Request $request)
    {
        $this->authorize('viewAny', Car::class);

        // Cargamos todos los coches publicados con sus relaciones para el listado
        $cars = Car::with(['maker', 'model', 'fuelType', 'city', 'owner'])
            ->whereNotNull('published_at')
            ->get();

        // Calculamos las estadísticas que aparecerán en el resumen del informe
        $totalCoches  = $cars->count();
        $precioMedio  = $cars->avg('price') ?? 0;
        $precioMin    = $cars->min('price') ?? 0;
        $precioMax    = $cars->max('price') ?? 0;

        // Agrupamos por marca para la tabla de marcas más publicadas
        $porMarca = Car::whereNotNull('published_at')
            ->join('makers', 'cars.maker_id', '=', 'makers.id')
            ->selectRaw('makers.name as maker, COUNT(*) as total, AVG(price) as precio_medio')
            ->groupBy('makers.name')
            ->orderByDesc('total')
            ->get();

        $datos = compact('cars', 'totalCoches', 'precioMedio', 'precioMin', 'precioMax', 'porMarca');

        return $this->pdfService->download('pdfs.cars-report', $datos, 'informe-anuncios.pdf');
    }
}
