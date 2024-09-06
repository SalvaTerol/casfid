<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChangeLocaleController extends Controller
{
    public function __invoke($locale)
    {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
}
