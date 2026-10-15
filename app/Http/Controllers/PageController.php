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
        //Dit is de filter voor mijn producten in de URL!
        return view('brands', [
            'brand' => $brand,
        ]);
    }
}
