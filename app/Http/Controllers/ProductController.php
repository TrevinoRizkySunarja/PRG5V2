<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'brand' => ['nullable', 'string', Rule::in(config('library.brands'))],
            'category' => ['nullable', 'string', Rule::in(config('library.categories'))],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = Product::query()->where('is_active', true);

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

        $products = $query->orderBy('title')->orderBy('id')->paginate(9)->withQueryString();

        if ($request->expectsJson()) {
            return response()->json($products);
        }

        $pageTitle = config('library.name');
        $brands = config('library.brands');
        $categories = config('library.categories');

        return view('products.index', [
            'pageTitle' => $pageTitle,
            'brands' => $brands,
            'categories' => $categories,
            'products' => $products,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('products.create', ['product' => new Product()]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $product = $request->user()->products()->create($this->validatedData($request));

        if ($request->expectsJson()) {
            return response()->json(['data' => $product->refresh()], 201)
                ->header('Location', route('products.show', $product));
        }

        return redirect()->route('products.show', $product)->with('status', 'Product toegevoegd.');
    }

    public function show(Request $request, Product $product): View|JsonResponse
    {
        if (! $product->is_active) {
            $user = $request->user();
            abort_unless($user && ($user->isAdmin() || (int) $product->user_id === (int) $user->getKey()), 404);
        }

        if ($request->expectsJson()) {
            return response()->json(['data' => $product]);
        }

        return view('products.show', [
            'product' => $product,
            'reviews' => $product->reviews()->with('user')->latest()->paginate(5),
        ]);
    }

    public function edit(Request $request, Product $product): View
    {
        Gate::authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        Gate::authorize('update', $product);
        $product->update($this->validatedData($request, $product));

        if ($request->expectsJson()) {
            return response()->json(['data' => $product->refresh()]);
        }

        return redirect()->route('products.show', $product)->with('status', 'Product bijgewerkt.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        Gate::authorize('delete', $product);
        $product->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Product verwijderd.']);
        }

        return redirect()->route('products.index')->with('status', 'Product verwijderd.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        $brand = $request->input('brand');
        $uniqueTitle = Rule::unique('products', 'title')
            ->where(fn ($query) => $query->where('brand', is_string($brand) ? $brand : ''));

        if ($product !== null) {
            $uniqueTitle->ignore($product->getKey());
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:100', $uniqueTitle],
            'description' => ['required', 'string', 'max:2000'],
            'brand' => ['required', Rule::in(config('library.brands'))],
            'category' => ['required', Rule::in(config('library.categories'))],
            'price' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
        ]);
    }
}
