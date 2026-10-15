<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $pageTitle = 'Gaming Products Library';

        return view('products.index', [
            'pageTitle' => $pageTitle,
        ]);
    }

    public function create()
    {
        // Les 3 oefent de routes; formulieren en opslag volgen later.
        abort(501, 'Producten aanmaken is nog niet uitgewerkt.');
    }

    public function store(Request $request)
    {
        abort(501, 'Producten opslaan is nog niet uitgewerkt.');
    }

    public function show(string $product)
    {
        // De routeparameter is voorlopig alleen een ID, geen databaseproduct.
        return view('products.show', [
            'productId' => $product,
        ]);
    }

    public function edit(string $product)
    {
        abort(501, 'Producten bewerken is nog niet uitgewerkt.');
    }

    public function update(Request $request, string $product)
    {
        abort(501, 'Producten wijzigen is nog niet uitgewerkt.');
    }

    public function destroy(string $product)
    {
        abort(501, 'Producten verwijderen is nog niet uitgewerkt.');
    }
}
