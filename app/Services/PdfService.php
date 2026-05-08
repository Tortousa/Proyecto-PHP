<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

// Servicio centralizado para generar PDFs.
// Los controladores no saben nada de dompdf — solo llaman a este servicio
// pasándole la vista y los datos. Si algún día cambiamos la librería de PDFs,
// solo hay que tocar aquí.
class PdfService
{
    // Genera el PDF y lo devuelve listo para descargar.
    // $view  → nombre de la vista blade que usaremos como plantilla
    // $data  → variables que necesita esa vista
    // $name  → nombre del archivo que descargará el usuario
    public function download(string $view, array $data, string $name): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'portrait');

        return $pdf->download($name);
    }

    // Igual que download() pero muestra el PDF en el navegador en vez de descargarlo
    public function stream(string $view, array $data, string $name): \Symfony\Component\HttpFoundation\Response
    {
        $pdf = Pdf::loadView($view, $data)->setPaper('a4', 'portrait');

        return $pdf->stream($name);
    }
}
