<?php

use App\Models\LoginDay;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

function reviewInput(array $overrides = []): array
{
    return array_merge([
        'title' => 'Goede headset',
        'rating' => 4,
        'content' => 'Het geluid is helder en de pasvorm is comfortabel.',
    ], $overrides);
}

it('stores an authenticated review related to its product and author', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();

    foreach (range(0, 4) as $day) {
        LoginDay::create(['user_id' => $user->id, 'login_date' => now()->subDays($day)->toDateString()]);
    }

    $this->actingAs($user)->post(route('products.reviews.store', $product), reviewInput())
        ->assertRedirect(route('products.show', $product));

    $review = Review::firstOrFail();
    expect($product->reviews->first()->is($review))->toBeTrue();
    expect($review->product->is($product))->toBeTrue();
    expect($review->user->is($user))->toBeTrue();

    $this->get(route('products.show', $product))
        ->assertOk()->assertSee('Goede headset')->assertSee('4 van 5 sterren')
        ->assertSee($user->name);
});

it('requires login and valid input to place a review', function () {
    $product = Product::factory()->create();
    $this->post(route('products.reviews.store', $product), reviewInput())
        ->assertRedirect(route('login'));

    $this->actingAs(User::factory()->create())
        ->post(route('products.reviews.store', $product), reviewInput([
            'title' => '', 'rating' => 6, 'content' => 'Kort',
        ]))->assertSessionHasErrors(['title', 'rating', 'content']);
    $this->assertDatabaseCount('reviews', 0);
});

it('only allows a review author to remove their own review', function () {
    $review = Review::factory()->create();
    $otherUser = User::factory()->create();

    $this->actingAs($otherUser)->delete(route('reviews.destroy', $review))->assertForbidden();
    $this->assertDatabaseCount('reviews', 1);

    $this->actingAs($review->user)->delete(route('reviews.destroy', $review))
        ->assertRedirect(route('products.show', $review->product));
    $this->assertDatabaseCount('reviews', 0);
});

it('retains reviews when a product is soft deleted', function () {
    $review = Review::factory()->create();
    $review->product->delete();

    $this->assertDatabaseCount('reviews', 1);
    $this->get(route('products.show', $review->product_id))->assertNotFound();
});


it('requires five distinct successful login days before writing a review', function () {
    $product = Product::factory()->create();
    $user = User::factory()->create();
    $this->actingAs($user);

    foreach (range(0, 3) as $day) {
        LoginDay::create(['user_id' => $user->id, 'login_date' => now()->subDays($day)->toDateString()]);
    }

    $this->post(route('products.reviews.store', $product), reviewInput())
        ->assertSessionHasErrors('review_eligibility');
    $this->assertDatabaseCount('reviews', 0);

    LoginDay::create(['user_id' => $user->id, 'login_date' => now()->subDays(4)->toDateString()]);
    $this->post(route('products.reviews.store', $product), reviewInput())->assertRedirect();
    $this->assertDatabaseCount('reviews', 1);
});
