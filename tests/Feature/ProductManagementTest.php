<?php

use App\Models\Product;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

function productInput(array $overrides = []): array
{
    return array_merge([
        'title' => 'G Pro X 2',
        'description' => 'Lichte draadloze gamingmuis voor snelle bewegingen.',
        'brand' => 'Logitech',
        'category' => 'Muizen',
        'price' => '119.95',
    ], $overrides);
}

it('requires an account to manage products', function () {
    $product = Product::factory()->create();

    $this->get(route('products.create'))->assertRedirect(route('login'));
    $this->post(route('products.store'), productInput())->assertRedirect(route('login'));
    $this->get(route('products.edit', $product))->assertRedirect(route('login'));
    $this->patch(route('products.update', $product), productInput())->assertRedirect(route('login'));
    $this->delete(route('products.destroy', $product))->assertRedirect(route('login'));
});

it('allows an authenticated user to create, edit and soft-delete their own product', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('products.create'))->assertOk()->assertSee('Product toevoegen');

    $this->post(route('products.store'), productInput())
        ->assertRedirect();

    $product = Product::where('title', 'G Pro X 2')->firstOrFail();
    expect($product->user->is($user))->toBeTrue();
    $this->get(route('products.edit', $product))->assertOk()->assertSee($product->title);

    $this->patch(route('products.update', $product), productInput(['title' => 'G Pro X 2 Special']))
        ->assertRedirect(route('products.show', $product));
    $this->assertDatabaseHas('products', ['id' => $product->id, 'title' => 'G Pro X 2 Special']);

    $this->delete(route('products.destroy', $product))->assertRedirect(route('products.index'));
    $this->get(route('products.show', $product))->assertNotFound();
    $this->assertSoftDeleted('products', ['id' => $product->id]);
    expect(Product::withTrashed()->findOrFail($product->id)->reviews()->count())->toBe(0);
});

it('prevents editing or deleting products owned by another user or the demo catalog', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $owned = Product::factory()->for($owner, 'user')->create();
    $demo = Product::factory()->create(['user_id' => null]);

    $this->actingAs($otherUser);
    foreach ([$owned, $demo] as $product) {
        $this->get(route('products.edit', $product))->assertForbidden();
        $this->patch(route('products.update', $product), productInput())->assertForbidden();
        $this->delete(route('products.destroy', $product))->assertForbidden();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'deleted_at' => null]);
    }
});

it('validates product input and prevents a duplicate title within the same brand', function () {
    Product::factory()->create(['brand' => 'Logitech', 'title' => 'G Pro X 2']);
    $this->actingAs(User::factory()->create());

    $this->post(route('products.store'), productInput())->assertSessionHasErrors('title');
    $this->post(route('products.store'), productInput([
        'title' => str_repeat('A', 101),
        'brand' => 'Onbekend',
        'price' => -10,
    ]))->assertSessionHasErrors(['title', 'brand', 'price']);
    $this->assertDatabaseCount('products', 1);
});

it('keeps soft deleted demo products hidden after seeding again', function () {
    $this->seed(DatabaseSeeder::class);
    $product = Product::firstOrFail();
    $product->delete();

    $this->seed(DatabaseSeeder::class);
    expect(Product::count())->toBe(11);
    expect(Product::withTrashed()->count())->toBe(12);
});
