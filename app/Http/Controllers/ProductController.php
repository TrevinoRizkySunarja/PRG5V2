<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', Rule::in(config('library.brands'))],
            'category' => ['nullable', 'string', Rule::in(config('library.categories'))],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = Product::query();

        if (filled($filters['q'] ?? null)) {
            $search = '%'.$filters['q'].'%';
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', $search)
                    ->orWhere('description', 'like', $search);
            });
        }

        foreach (['brand', 'category'] as $column) {
            if (filled($filters[$column] ?? null)) {
                $query->where($column, $filters[$column]);
            }
        }

        $pageTitle = config('library.name');
        $brands = config('library.brands');
        $categories = config('library.categories');

        return view('products.index', [
            'pageTitle' => $pageTitle,
            'brands' => $brands,
            'categories' => $categories,
            'products' => $query->orderBy('title')->orderBy('id')->paginate(9)->withQueryString(),
            'filters' => $filters,
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

    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product,
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
