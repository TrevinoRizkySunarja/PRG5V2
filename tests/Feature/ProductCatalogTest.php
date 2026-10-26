<?php

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

it('shows database products and a real detail page', function () {
    $product = Product::factory()->create([
        'title' => 'G Pro X Superlight',
        'brand' => 'Logitech',
        'category' => 'Muizen',
        'price' => '129.90',
    ]);

    $this->get(route('products.index'))
        ->assertOk()->assertSee($product->title)->assertSee('129,90')
        ->assertSee(route('products.show', $product), false);

    $this->get(route('products.show', $product))
        ->assertOk()->assertSee($product->title)->assertSee($product->description)
        ->assertSee('Logitech')->assertSee('Muizen')->assertSee('129,90');

    expect($product->fresh()->price)->toBe('129.90');
});

it('returns 404 for a numeric product that does not exist', function () {
    $this->get('/products/999999')->assertNotFound();
});

it('combines searching in both columns with brand and category filters', function () {
    $matchingTitle = Product::factory()->create([
        'title' => 'Draadloos toetsenbord', 'brand' => 'Logitech', 'category' => 'Toetsenborden',
    ]);
    $matchingDescription = Product::factory()->create([
        'title' => 'Compact toetsenbord', 'description' => 'Speel draadloos met je team.',
        'brand' => 'Logitech', 'category' => 'Toetsenborden',
    ]);
    $wrongBrand = Product::factory()->create([
        'title' => 'Andere draadloos', 'brand' => 'Razer', 'category' => 'Toetsenborden',
    ]);
    $wrongCategory = Product::factory()->create([
        'title' => 'Muis draadloos', 'brand' => 'Logitech', 'category' => 'Muizen',
    ]);
    $wrongText = Product::factory()->create([
        'title' => 'Kabelmodel', 'description' => 'Met kabel.',
        'brand' => 'Logitech', 'category' => 'Toetsenborden',
    ]);

    $this->get(route('products.index', ['q' => 'draadloos', 'brand' => 'Logitech', 'category' => 'Toetsenborden']))
        ->assertOk()->assertSee($matchingTitle->title)->assertSee($matchingDescription->title)
        ->assertDontSee($wrongBrand->title)->assertDontSee($wrongCategory->title)->assertDontSee($wrongText->title);
});

it('shows an empty state for an empty database or no matching products', function () {
    $this->get(route('products.index'))->assertOk()->assertSee('Geen producten gevonden');
    Product::factory()->create(['title' => 'Gamingmuis', 'description' => 'Met kabel.']);
    $this->get(route('products.index', ['q' => 'doesnotexist']))
        ->assertOk()->assertSee('0 producten gevonden')->assertSee('Geen producten gevonden');
});

it('paginates products and keeps the selected filters', function () {
    Product::factory()->count(10)->create(['brand' => 'Razer', 'category' => 'Muizen']);

    $this->get(route('products.index', ['brand' => 'Razer', 'category' => 'Muizen']))
        ->assertOk()->assertViewHas('products', fn ($products) => $products->count() === 9 && $products->total() === 10)
        ->assertSee('brand=Razer', false)->assertSee('category=Muizen', false)->assertSee('page=2', false);

    $this->get(route('products.index', ['brand' => 'Razer', 'category' => 'Muizen', 'page' => 2]))
        ->assertOk()->assertViewHas('products', fn ($products) => $products->count() === 1);
});

it('rejects invalid filters server side', function (array $filters, string $field) {
    $this->getJson(route('products.index', $filters))->assertUnprocessable()->assertJsonValidationErrors($field);
})->with([
    [['q' => str_repeat('a', 101)], 'q'],
    [['q' => ['unexpected']], 'q'],
    [['brand' => 'Unknown'], 'brand'],
    [['category' => 'Unknown'], 'category'],
    [['page' => -1], 'page'],
]);

it('escapes product content and treats SQL-like search input as data', function () {
    $product = Product::factory()->create([
        'title' => '<script>alert(1)</script>',
        'description' => '<img src=x onerror=alert(1)>',
    ]);

    foreach ([route('products.index'), route('products.show', $product)] as $url) {
        $this->get($url)->assertOk()
            ->assertSee(e($product->title), false)->assertDontSee($product->title, false)
            ->assertSee(e($product->description), false)->assertDontSee($product->description, false);
    }

    $this->get(route('products.index', ['q' => "' OR 1=1 --"]))
        ->assertOk()->assertSee('Geen producten gevonden');
    $this->assertDatabaseCount('products', 1);
});

it('seeds the catalog repeatedly without duplicate products or overwriting existing data', function () {
    $user = User::factory()->create();
    $this->seed(DatabaseSeeder::class);
    $product = Product::query()->firstOrFail();
    $product->update(['description' => 'Mijn aangepaste beschrijving']);

    $this->seed(DatabaseSeeder::class);

    $this->assertDatabaseCount('products', 12);
    $this->assertDatabaseCount('users', 1);
    expect($user->fresh())->not->toBeNull();
    expect($product->fresh()->description)->toBe('Mijn aangepaste beschrijving');
});
