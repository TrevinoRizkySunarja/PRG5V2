<?php
use App\Models\Product;
use App\Models\User;

it('protects admin moderation and toggles product status using POST', function () {
    $product = Product::factory()->create();
    $member = User::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $this->get(route('admin.products.index'))->assertRedirect(route('login'));
    $this->actingAs($member)->get(route('admin.products.index'))->assertForbidden();
    $this->post(route('admin.products.toggle-status', $product))->assertForbidden();
    $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
    $this->post(route('admin.products.toggle-status', $product))->assertRedirect(route('admin.products.index'));
    expect($product->fresh()->is_active)->toBeFalse();
    $this->get(route('products.index'))->assertDontSee($product->title);
});

it('blocks direct editing by non-owners even when they are admins', function () {
    $owner = User::factory()->create();
    $admin = User::factory()->create(['role' => 'admin']);
    $product = Product::factory()->create(['user_id' => $owner->id]);
    $this->actingAs($admin)->get(route('products.edit', $product))->assertForbidden();
    $this->delete(route('products.destroy', $product))->assertForbidden();
    $this->actingAs($owner)->get(route('products.edit', $product))->assertOk();
});

it('hides inactive items from visitors but lets their owners view them', function () {
    $owner = User::factory()->create();
    $product = Product::factory()->create(['user_id' => $owner->id, 'is_active' => false]);
    $this->get(route('products.show', $product))->assertNotFound();
    $this->actingAs($owner)->get(route('products.show', $product))->assertOk();
});
