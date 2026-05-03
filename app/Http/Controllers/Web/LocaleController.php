<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

// Gestiona el cambio de idioma de la aplicación.
// El idioma elegido se guarda en sesión y el middleware SetLocale lo aplica en cada petición.
class LocaleController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        // Solo aceptamos los idiomas que tenemos traducidos
        if (in_array($locale, ['en', 'es'])) {
            Session::put('locale', $locale);
        }

        return back();
    }
}
