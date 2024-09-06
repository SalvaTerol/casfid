<?php

namespace App\Http\Controllers;

class ChangeLocaleController extends Controller
{
    public function __invoke($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }
}
