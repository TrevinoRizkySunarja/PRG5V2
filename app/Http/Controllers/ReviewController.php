<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'content' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        $product->reviews()->create([
            ...$data,
            'user_id' => $request->user()->getKey(),
        ]);

        return redirect()->route('products.show', $product)->with('status', 'Review geplaatst.');
    }

    public function destroy(Request $request, Review $review): RedirectResponse
    {
        abort_unless($review->user_id == $request->user()->getKey(), 403);

        $product = $review->product()->withTrashed()->firstOrFail();
        $review->delete();

        if ($product->trashed()) {
            return redirect()->route('products.index')->with('status', 'Review verwijderd.');
        }

        return redirect()->route('products.show', $product)->with('status', 'Review verwijderd.');
    }
}
