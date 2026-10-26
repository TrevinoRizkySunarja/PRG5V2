<?php

use Illuminate\Support\Facades\Route;

it('serves the library pages through named routes', function (string $name, string $heading) {
    $this->get(route($name))->assertOk()->assertSee($heading);
})->with([
    ['home', 'Gaming Products Library'],
    ['about', 'Over Gaming Products Library'],
    ['contact', 'Contact'],
    ['products.index', 'Gaming Products Library'],
]);

it('redirects the old home address', function () {
    $this->get('/home')->assertRedirect('/');
});

it('accepts the brand route with and without its optional parameter', function () {
    $this->get(route('brands'))->assertOk()->assertSee('Alle merken');
    $this->get(route('brands', ['brand' => 'Logitech']))->assertOk()->assertSee('Logitech');
    $this->get('/brands/Unknown')->assertNotFound();
});

it('rejects invalid product identifiers', function () {
    $this->get('/products/not-an-id')->assertNotFound();
    $this->get('/products/-1')->assertNotFound();
});

it('registers all seven resource actions with the correct HTTP methods', function () {
    foreach ([
        'index' => ['GET', 'HEAD'],
        'create' => ['GET', 'HEAD'],
        'store' => ['POST'],
        'show' => ['GET', 'HEAD'],
        'edit' => ['GET', 'HEAD'],
        'update' => ['PUT', 'PATCH'],
        'destroy' => ['DELETE'],
    ] as $action => $methods) {
        expect(Route::getRoutes()->getByName('products.'.$action)->methods())->toBe($methods);
    }

    expect(route('products.show', ['product' => 24], false))->toBe('/products/24');
});
