<?php

use App\Models\Product;
use App\Models\User;

function jsonProductInput(array $overrides = []): array
{
    return array_merge([
        'title' => 'Postman demo mouse',
        'description' => 'Product voor de HTTP-demonstratie.',
        'brand' => 'Logitech',
        'category' => 'Muizen',
        'price' => '49.95',
    ], $overrides);
}

it('supports JSON create read patch put and soft delete', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->postJson('/products', jsonProductInput())
        ->assertCreated()->assertJsonPath('data.user_id', $user->id);
    $id = $response->json('data.id');
    $response->assertHeader('Location', route('products.show', $id));
    $this->assertDatabaseHas('products', ['id' => $id, 'user_id' => $user->id]);
    $this->getJson('/products/'.$id)->assertOk()->assertJsonPath('data.title', 'Postman demo mouse');
    $this->patchJson('/products/'.$id, jsonProductInput(['title' => 'PATCH demo']))
        ->assertOk()->assertJsonPath('data.title', 'PATCH demo');
    $this->putJson('/products/'.$id, jsonProductInput(['title' => 'PUT demo']))
        ->assertOk()->assertJsonPath('data.title', 'PUT demo');
    $this->assertDatabaseHas('products', ['id' => $id, 'title' => 'PUT demo']);
    $this->deleteJson('/products/'.$id)->assertOk()->assertJsonPath('message', 'Product verwijderd.');
    $this->assertSoftDeleted('products', ['id' => $id]);
    $this->getJson('/products/'.$id)->assertNotFound();
});

it('keeps authentication authorization and validation on JSON requests', function () {
    $product = Product::factory()->for(User::factory(), 'user')->create();
    $this->postJson('/products', jsonProductInput())->assertUnauthorized();
    $this->actingAs(User::factory()->create());
    $this->patchJson('/products/'.$product->id, jsonProductInput())->assertForbidden();
    $this->deleteJson('/products/'.$product->id)->assertForbidden();
    $this->postJson('/products', jsonProductInput(['price' => -1]))
        ->assertUnprocessable()->assertJsonValidationErrors('price');
    $this->assertDatabaseCount('products', 1);
    $this->assertNotSoftDeleted($product);
});

it('combines JSON search and filters and hides inactive products', function () {
    $match = Product::factory()->create(['title' => 'Unique search demo', 'brand' => 'Logitech', 'category' => 'Muizen', 'is_active' => true]);
    Product::factory()->create(['title' => 'Unique search demo', 'brand' => 'Razer', 'category' => 'Muizen', 'is_active' => true]);
    $hidden = Product::factory()->create(['title' => 'Unique search demo hidden', 'brand' => 'Logitech', 'category' => 'Muizen', 'is_active' => false]);
    $this->getJson('/products?q=Unique&brand=Logitech&category=Muizen')
        ->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.id', $match->id);
    $this->getJson('/products/'.$hidden->id)->assertNotFound();
});
