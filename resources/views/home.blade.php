<x-library-layout title="Home | Gaming Products Library">
    <h1>Gaming Products Library</h1>
    <p>Ontdek gamingmuizen, headsets en toetsenborden van Logitech, Corsair, HyperX en Razer.</p>

    <h2>Vind jouw volgende gamingproduct</h2>
    <p>Bekijk producten op één plek en ontdek welk merk en welke productsoort bij jouw setup passen.</p>
    <p><a href="{{ route('products.index') }}">Ontdek de productbibliotheek</a></p>
    @auth
        <section class="mt-6 border-t border-slate-300 pt-6">
            <h2>Jouw account</h2>
            <p>Welkom terug, {{ auth()->user()->name }}.</p>
            <p><a href="{{ route('profile.edit') }}">Beheer je profiel</a></p>
        </section>
    @endauth

    @guest
        <p><a href="{{ route('login') }}">Log in</a> om je profiel te beheren.</p>
    @endguest
</x-library-layout>
