<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductModerationController extends Controller
{
    public function index(): View
    {
        Gate::authorize('access-admin');

        return view('admin.products.index', [
            'products' => Product::query()->with('user')->latest()->paginate(15),
        ]);
    }

    // Aparte controlleractie, uitsluitend aangeroepen met POST.
    public function toggleStatus(Request $request, Product $product): RedirectResponse
    {
        Gate::authorize('access-admin');

        $product->is_active = ! $product->is_active;
        $product->save();

        Log::info('Productstatus gewijzigd', [
            'admin_id' => $request->user()->getKey(),
            'product_id' => $product->getKey(),
            'is_active' => $product->is_active,
        ]);

        return redirect()->route('admin.products.index')->with('status', 'Productstatus gewijzigd.');
    }
}
