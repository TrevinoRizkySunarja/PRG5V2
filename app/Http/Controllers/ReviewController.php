<?php

namespace App\Http\Controllers;

use App\Models\LoginDay;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'content' => ['required', 'string', 'min:5', 'max:2000'],
        ]);

        // Verplichte diepere validatie met een afzonderlijke Eloquent-query.
        $loginDays = LoginDay::query()
            ->where('user_id', $request->user()->getKey())
            ->count();

        if ($loginDays < 5) {
            return back()->withErrors([
                'review_eligibility' => 'Je kunt een review plaatsen na inloggen op vijf verschillende dagen ('.$loginDays.'/5).',
            ])->withInput();
        }

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
