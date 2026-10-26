<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function about(): View
    {
        return view('about-us', [
            'company' => config('library.name'),
            'brands' => config('library.brands'),
            'categories' => config('library.categories'),
        ]);
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function brands(string $brand = 'Alle merken'): View
    {
        // Ontvangt de merknaam uit de URL; filtert nog geen producten.
        return view('brands', [
            'brand' => $brand,
            'brands' => config('library.brands'),
        ]);
    }
}
