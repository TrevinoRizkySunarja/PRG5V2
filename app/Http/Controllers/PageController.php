<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        $company = 'Gaming Products Library';

        return view('about-us', [
            'company' => $company,
        ]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function brands(string $brand = 'Alle merken')
    {
        // Ontvangt de merknaam uit de URL; filtert nog geen producten.
        return view('brands', [
            'brand' => $brand,
        ]);
    }
}
