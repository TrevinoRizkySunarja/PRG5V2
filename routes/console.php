<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('library:make-admin {email}', function () {
    $user = User::query()->where('email', $this->argument('email'))->first();

    if ($user === null) {
        $this->error('Geen gebruiker gevonden met dit e-mailadres.');
        return 1;
    }

    // Rollen kunnen niet via registratie of profiel-formulieren worden aangepast.
    $user->forceFill(['role' => 'admin'])->save();
    $this->info('Gebruiker heeft nu de adminrol.');
})->purpose('Promoveer een bestaand account tot admin via de serverconsole.');
