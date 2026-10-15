<x-library-layout title="Home | Gaming Products Library">
    <h1>Gaming Products Library</h1>
    <p>Ontdek gamingmuizen, headsets en toetsenborden van Logitech, Corsair, HyperX en Razer.</p>

    <h2>Voorbeeldproducten</h2>
    <ul>
        <li><a href="{{ route('products.show', ['product' => 1]) }}">Bekijk product 1</a></li>
        <li><a href="{{ route('products.show', ['product' => 24]) }}">Bekijk product 24</a></li>
    </ul>
    @auth
        <section class="library-account">
            <h2>Jouw account</h2>
            <p>Welkom terug, {{ auth()->user()->name }}.</p>
            <p><a href="{{ route('profile.edit') }}">Beheer je profiel</a></p>
        </section>
    @endauth

    @guest
        <p><a href="{{ route('login') }}">Log in</a> om je profiel te beheren.</p>
    @endguest
</x-library-layout>
