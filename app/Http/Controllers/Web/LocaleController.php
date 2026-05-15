<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

// Gestiona el cambio de idioma de la aplicación.
// El idioma elegido se guarda en sesión y el middleware SetLocale lo aplica en cada petición.
class LocaleController extends Controller
{
    private const SUPPORTED = ['es', 'en'];

    public function switch(string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, self::SUPPORTED, true), 404);

        Session::put('locale', $locale);

        return back();
    }
}
