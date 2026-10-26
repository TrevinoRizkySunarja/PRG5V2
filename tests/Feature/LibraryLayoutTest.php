<?php

use App\Models\User;

it('shows guest navigation and protects the dashboard', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Inloggen')
        ->assertSee('Registreren')
        ->assertDontSee('Uitloggen')
        ->assertDontSee('Jouw account');

    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

it('shows the account and logout form to authenticated users', function () {
    $user = User::factory()->create(['name' => 'Gaming bezoeker']);

    $this->actingAs($user)->get(route('home'))
        ->assertOk()
        ->assertSee('Gaming bezoeker')
        ->assertSee('Jouw account')
        ->assertSee('Uitloggen')
        ->assertSee('name="_token"', false)
        ->assertDontSee('Registreren');

    $this->get(route('dashboard'))->assertOk();
});

it('renders the shared layout, cards and the active navigation', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('<title>Over Gaming Products Library</title>', false)
        ->assertSee('aria-current="page"', false)
        ->assertSee('library-card', false)
        ->assertSee('Ontdek de producten van Logitech.');

    $this->get(route('test'))->assertOk()->assertSee('Test Page');
});
